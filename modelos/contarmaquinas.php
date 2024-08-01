<?php
session_start();
require_once "conexion.php";
$tablaord = "";
$datosJson = '';
$contar = 0;
if (isset($_POST["pk"])) {
  $otro="66E5502D-592D-48B0-B858-74822A83AC0A";
    $token= $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/maquinas_API_02/_find';
     $payloadName = '{"query": [{"fk_cliente_lersoft":"' . $_POST["pk"] .'"}]}';
     $requestAll = get_dataOne($host,$token,$payloadName); 
     $Contars = $requestAll->response->dataInfo->foundCount;

     if ($Contars === null) {
        $contar=0;
    } else {
        $contar=$Contars ;
    }

    
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
