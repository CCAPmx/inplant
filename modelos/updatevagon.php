<?php
session_start();

if (isset($_POST["fk_proyecto"])) {
   
    $token = $_SESSION["ccap"];
    date_default_timezone_set('America/Mexico_City');
 
    $fecha_actual = date("d-m-Y");
    $timestamp = strtotime($fecha_actual); 
$newDate = date("m/d/y", $timestamp );

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/vagones_web_detalle/records';
    $datos = '
    {
    "fieldData": {
        "alias_produccion": "' . $_POST["alias_produccion"] . '",
        "fk_maquina": "' . $_POST["maquina"] . '",
        "fkProducto": "' . $_POST["fkProducto"] . '",
        "flag_regranallado": "' . $_POST["flag_regranallado"] . '",
        "fk_proyecto": "' . $_POST["fk_proyecto"] . '",
         "serie_proyecto": "' . $_POST["serie_proyecto"] . '",
         "fkCliente": "' . $_POST["fkCliente"] . '",
         "fk_cliente_lersoft": "' . $_POST["fk_cliente_lersoft"] . '"
      }
   }';
    $requestOrden = get_dataOne($host, $token, $datos);
    $contar = $requestOrden->messages;

    $json_string = json_encode($contar);
    echo  $json_string;
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
