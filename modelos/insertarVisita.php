<?php
session_start();

header('Access-Control-Allow-Origin: *');
date_default_timezone_set('America/Denver');
$input = json_decode(file_get_contents('php://input'), true);
$token = $_SESSION["ccap"];

// var_dump($input);


// $host = "https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/supervisores_web/records";
// $body = '{
//     "fieldData": {
//       "fk_maquina": "' . $input['fk_maquina'] . '",
//       "nombre": "' . $input['nombre'] . '",
//       "apellidos": "' . $input['apellidos'] . '",
//       "fk_cliente_lersoft": "' . $input['fk_cliente_lersoft'] . '"
//     }
//   }';

$timestamp = strtotime($input['fecha']);
$host = "https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/visita_tecnica_web_sencilla/records";
$body = '{
    "fieldData": {
      "fkMaquina": "' . $input['fkMaquina'] . '",
      "fkCliente": "' . $input['fkCliente'] . '",      
      "nombre_usuario": "' .  $_SESSION["nombre"] . '",      
      "fecha": "'.date("m/d/Y",$timestamp).'"    
    }
  }';

  

//    var_dump($host, $body,$token);
$requestSupervisor = get_dataOne($host, $token, $body);

// var_dump($requestSupervisor);

if (intval($requestSupervisor->messages[0]->code) == 0) {
    $array = [
        'success' => true,
        'response' => $requestSupervisor->response->recordId,
        'message' => 'Visita registrada con exito',
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
