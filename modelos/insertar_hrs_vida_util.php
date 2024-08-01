<?php
session_start();

header('Access-Control-Allow-Origin: *');
$input = json_decode(file_get_contents('php://input'), true);
$token = $_SESSION["ccap"];

// var_dump($input['pk']);
// var_dump($input['hrs_vida_util']);
$host = "https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/partes_vida_util_web/records";
$body = '
{
    "fieldData": {       
        "fk_parte_maquina": "'.$input['pk'].'",
        "vida_util": '.$input['hrs_vida_util'].',
        "usuario": ""
    }
    
}
';

$requestSupervisor = get_dataOne($host, $token, $body);

// var_dump($requestSupervisor->messages[0]->code);

if (intval($requestSupervisor->messages[0]->code) == 0) {
    $array = [
        'success' => true,
        'message' => 'Horas  registradas con exito',
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






function get_dataOne($host, $token, $payloadName)
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
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
    $result = curl_exec($ch);
    curl_close($ch);
    $json_data = json_decode($result);

    return $json_data;
};
