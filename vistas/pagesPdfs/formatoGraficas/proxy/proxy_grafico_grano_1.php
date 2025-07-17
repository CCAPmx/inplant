<?php
// Validación básica para evitar abuso
if (!isset($_GET['a1'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta parámetro a1']);
    exit;
}

$param = urlencode($_GET['a1']);
$url = "https://dooble-inox.com/apc/batch_page/graficos_reporte_gbx.php?a1=$param";

// Llama al servidor externo
$options = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: InplantProxy/1.0\r\n"
    ]
];
$context = stream_context_create($options);
$response = @file_get_contents($url, false, $context);

// Manejo de error
if ($response === FALSE) {
    http_response_code(502);
    echo json_encode(['error' => 'Error al contactar el servidor externo']);
    exit;
}

// Decodifica la respuesta externa
$data_externa = json_decode($response, true);

include $_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php';

$id = $_GET['a1']; // ✅ Ahora sí lo defines

$sql = "SELECT nombre_maquina, procesador,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha_formateada FROM granulometria WHERE id = :id"; // ⬅️ Ajusta 'id' al nombre real de tu columna
$sqlComentario = "SELECT comment_01, comment_02, comment_03, comment_04 FROM reporte_especial WHERE id_granulometria = :id"; // ⬅️ Ajusta 'id_reporte' al nombre real de tu columna

$objConexion = new Conexion();
$stmt = $objConexion->conectarDooble()->prepare($sql);
$stmt->execute(['id' => $id]);
$datosLocales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtComentario = $objConexion->conectarDooble()->prepare($sqlComentario);
$stmtComentario->execute(['id' => $id]);
$comentarios = $stmtComentario->fetch(PDO::FETCH_ASSOC);


$sqlMaquinaGranalla = "SELECT g.nombre as nombre_cabina from maquinas as m 
inner join granallas as g  on m.granalla_default = g.codigo_lersan 
WHERE m.procesador_maq  = :procesador";
$stmtMaquinaGranalla = $objConexion->conectarDooble()->prepare($sqlMaquinaGranalla);
$stmtMaquinaGranalla->execute(['procesador' => $datosLocales[0]['procesador']]);
$datosGranalla = $stmtMaquinaGranalla->fetch(PDO::FETCH_ASSOC);

// ✅ Agrega los datos locales al JSON externo
$data_externa['datos_locales_maquina'] = $datosGranalla;



$data_externa['comentarios'] = $comentarios;



// ✅ Agrega los datos locales al JSON externo
$data_externa['datos_locales'] = $datosLocales;

// Retorna JSON combinado
header("Content-Type: application/json");
echo json_encode($data_externa);
