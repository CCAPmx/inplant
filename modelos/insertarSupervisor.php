<?php
session_start();

header('Access-Control-Allow-Origin: *');
$input = json_decode(file_get_contents('php://input'), true);
$token = $_SESSION["ccap"];

// var_dump($input['fk_maquina']);


$host = "https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/supervisores_web/records";
$body = '{
    "fieldData": {
      "fk_maquina": "' . $input['fk_maquina'] . '",
      "nombre": "' . $input['nombre'] . '",
      "apellidos": "' . $input['apellidos'] . '",
      "fk_cliente_lersoft": "' . $input['fk_cliente_lersoft'] . '"
    }
  }';

$requestSupervisor = get_dataOne($host, $token, $body);

// var_dump($requestSupervisor->messages[0]->code);

if (intval($requestSupervisor->messages[0]->code) == 0) {
    $array = [
        'success' => true,
        'message' => 'Superviso registrado con exito',
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




// if (isset($_POST["fk_proyecto"])) {

//     $token = $_SESSION["ccap"];



//     $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/vagones_web_detalle/records';
//     $datos = '
//     {
//     "fieldData": {
//         "alias_produccion": "' . $_POST["alias_produccion"] . '",
//         "fk_maquina": "' . $_POST["maquina"] . '",
//         "fkProducto": "' . $_POST["fkProducto"] . '",
//         "fk_proyecto": "' . $_POST["fk_proyecto"] . '",
//          "serie_proyecto": "' . $_POST["serie_proyecto"] . '",
//          "fkCliente": "' . $_POST["fkCliente"] . '",
//          "fk_cliente_lersoft": "' . $_POST["fk_cliente_lersoft"] . '"
//       }
//    }';
//     $requestOrden = get_dataOne($host, $token, $datos);
//     $contar = $requestOrden->messages;

//     $json_string = json_encode($contar);
//     echo  $json_string;
// }

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
