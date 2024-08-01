<?php
session_start();
require_once "conexion.php";
$tablaord = "";
$datosJson = '';
$contar = 0;
if (isset($_POST["pk"])) {
  
     $token= $_SESSION["lersant"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/orden_venta_web_02/_find';
    $payloadName = '{"query": [{"fk_empresa_cliente":"' . $_POST["pk"] . '"}]}';
    $requestOrden = get_dataOne($host, $token, $payloadName);
    $contar = $requestOrden->response->dataInfo->foundCount;

    echo  $contar;

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
