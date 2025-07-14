<?php
// Validación básica para evitar abuso
if (!isset($_GET['a1'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta parámetro a1']);
    exit;
}

// Prepara la URL del servidor externo
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

// Retorna JSON
header("Content-Type: application/json");
echo $response;
