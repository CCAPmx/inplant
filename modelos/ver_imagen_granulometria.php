<?php
require_once "conexion.php";

$id = intval($_GET['id'] ?? 0);
$campo = $_GET['campo'] ?? '';

$camposPermitidos = ['basura_img01', 'basura_img02'];
if (!in_array($campo, $camposPermitidos)) {
    http_response_code(400);
    exit("Campo inválido");
}

try {
    $db = (new conexion())->conectarDooble();
    $stmt = $db->prepare("SELECT $campo FROM granulometria WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $imagen = $stmt->fetchColumn();

    if (!$imagen) {
        // Imagen por defecto si no hay en base
        header("Content-Type: image/png");
        readfile("img/no-image.png");
        exit;
    }

    // Detectar tipo MIME automáticamente
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($imagen);

    // Validar que sea imagen soportada
    if (!in_array($mime, ['image/jpeg', 'image/png'])) {
        http_response_code(415); // Unsupported Media Type
        exit("Tipo de imagen no soportado");
    }

    header("Content-Type: $mime");
    echo $imagen;

} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
