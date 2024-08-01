<?php
session_start();

if (isset($_POST["fk_cliente_lersoft"])) {
   
    $token = $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/supervisores_turnos_web/records';
    $datos = '
    {
    "fieldData": {
        
        "fk_cliente_lersoft": "' . $_POST["fk_cliente_lersoft"] . '",
        "fk_maquina": "' . $_POST["fk_maquina"] . '",
         "fk_supervisor": "' . $_POST["fk_supervisor"] . '",
         "fk_modo_turno": "' . $_POST["fk_modo_turno"]. '",
         "fk_turno": "' . $_POST["fk_turno"] . '",
         "fecha_ini": "' . $_POST["fecha_ini"] . '",
         "fecha_fin": "' . $_POST["fecha_fin"] . '"
      }
   }';
    $requestOrden = get_dataOne($host, $token, $datos);   
    $contar = $requestOrden->messages;


      // Se aplica la validacion get
    $enpoint_validar = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/supervisores_turnos_web/script/GenerarDiasTurnos';
    $payloadName = '';
    $requestAll_validar = get_dataAll($enpoint_validar, $token, $payloadName);

  
    // var_dump($requestAll_validar);


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

function get_dataAll($host,$token,$payloadName) {
    $additionalHeaders = "Authorization: Bearer ".$token;
    $ch = curl_init();
    curl_setopt($ch,  CURLOPT_URL , $host);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( $additionalHeaders ));
    $result = curl_exec($ch);
    curl_close($ch);
    $json_data = json_decode($result);
    return $json_data;
};
