<?php
session_start();

if (isset($_POST["tipo"])) {
   
    $token = $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/solicitudes_web/records';
    $datos = '
    {
    "fieldData": {
        
        "fkgranalla": "' . $_POST["fkgranalla"] . '",
        "cantidad": "' . $_POST["cantidad"] . '",
         "usuario": "' . $_SESSION["usuario"] . '",
         "fkCliente": "' . $_POST["fkCliente"]. '",
         "tipo": "' . $_POST["tipo"] . '",
         "razon": "' . $_POST["razon"] . '",
         "fecha": "' . date("m/d/Y H:i:s", time()) .'"
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
