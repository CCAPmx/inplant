<?php
// session_start();
// date_default_timezone_set('America/Mexico_City');
// header('Access-Control-Allow-Origin: *');

// $token = $_SESSION["ccap"];
// var_dump($input["fk_maquina"]);

/* baja */
 $recordId = $_POST['recordId'];

//  var_dump($recordId);
$host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Partes_maquina_web/records/'.$recordId;
$datos =
'{
    "fieldData": {
        "activa": 0
    }
}';

$requestBaja = get_editar($host, $token, $datos);
// var_dump($request);

// if (intval($request->messages[0]->code) == 0) {
//     $array = [
//         'success' => true,
//         'message' => 'registrado con exito',
//         'status' => 200,
//     ];
//     echo json_encode($array);
// } else {

//     $array = [
//         'success' => false,
//         'message' => 'Error en el registro favor de validar datos',
//         'status' => 400
//     ];
//     echo json_encode($array);
// }

// $contar = $requestOrden->messages;


function get_editar($host, $token, $payloadName)
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
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
    $result = curl_exec($ch);
    curl_close($ch);
    $json_data = json_decode($result);

    return $json_data;
};

// $sMetodoPago = $_POST['recordId'];




/*Primero se da de baja la parte de la maquina */
