<?php
session_start();

date_default_timezone_set('America/Mexico_City');
header('Access-Control-Allow-Origin: *');
$token = $_SESSION["ccap"];
$host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/TipoPartesMaquina/records';
$payloadName = '';
$requestAll = get_dataAll($host, $token, $payloadName);


if (intval($requestAll->messages[0]->code) == 0) {
    
    $array = [
        'success' => true,
        'message' => 'tipos encontrados con exito',
        'data' => $requestAll->response->data,
        'status' => 200,
    ];
    echo json_encode($array);
} else {

    $array = [
        'success' => false,
        'message' => 'Error en el registro favor de validar datos',
        'status' => 400
    ];
    echo json_encode($array);
}

function get_dataAll($host, $token, $payloadName)
{
    $additionalHeaders = "Authorization: Bearer " . $token;
    $ch = curl_init();
    curl_setopt($ch,  CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($additionalHeaders));
    $result = curl_exec($ch);
    curl_close($ch);
    $json_data = json_decode($result);
    return $json_data;
};