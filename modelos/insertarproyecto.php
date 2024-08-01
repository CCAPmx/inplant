<?php
session_start();
require_once "conexion.php";
$tablaord = "";
$datosJson = '';
$contar = 0;
if (isset($_POST["Proyecto"])) {
    date_default_timezone_set('America/Mexico_City');
 
    $fecha_actual = date("d-m-Y");
    $timestamp = strtotime($fecha_actual); 
$newDate = date("m/d/y", $timestamp );


     $token= $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/proyectos_web/records';
    $datos = '
    {
    "fieldData": {
        "Proyecto": "' . $_POST["Proyecto"] . '",
                       "fecha": "' . $newDate . '",
                       "fkCliente": "' . $_POST["fkCliente"] . '",
                       "cantidad": "' . $_POST["cantidad"] . '",
                       "fk_cliente_lersoft": "' . $_POST["fk_cliente_lersoft"] . '",
                       "fk_tipo_vagon": "' . $_POST["fk_tipo_vagon"] . '",
                       "producto": "' . $_POST["producto"] . '"
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