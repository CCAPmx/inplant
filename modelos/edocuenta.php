<?php
session_start();
$tablaord = "";
$datosJson = '';
$contar = 0;
if (isset($_POST["rfc"])) {
    $limit=$_POST["limit"];
    $offset=$_POST["offset"];
     $token= $_SESSION["lersant"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/facturas_web/_find?';
    $payloadName = '{
        "query": [{"RFC_receptor":"' . $_POST["rfc"] . '","tipo_comprobante":"I"}],
        "limit": "' . $_POST["limit"] . '",
        "offset": "' . $_POST["offset"] . '",
        "sort":[
            {"fieldName": "fecha", "sortOrder": "descend"}
        ]
    }';

    $requestOrden = get_dataOne($host, $token, $payloadName);
    $Contarord = $requestOrden->response->dataInfo->returnedCount;
    $pedidos = array(); //creamos un array



    for ($i = 0; $i < $Contarord; $i++) {
        $fecha = $requestOrden->response->data[$i]->fieldData->{'fecha'};
        $serie = $requestOrden->response->data[$i]->fieldData->{'serie'};
        $folio = $requestOrden->response->data[$i]->fieldData->{'folio'};
        $importe = $requestOrden->response->data[$i]->fieldData->{'importe'};
        $IVA = $requestOrden->response->data[$i]->fieldData->{'IVA'};
        $Total = $requestOrden->response->data[$i]->fieldData->{'Total'};
        $moneda = $requestOrden->response->data[$i]->fieldData->{'moneda'};
        $saldo = $requestOrden->response->data[$i]->fieldData->{'saldo'};
        $status = $requestOrden->response->data[$i]->fieldData->{'status'};
        
        $mifecha = new DateTime($fecha);
        $mifecha = $mifecha->format('Y-m-d');


        $pedidos[] = array('fecha'=> $mifecha, 'serie'=> $serie, 'folio'=> $folio, 'importe'=> $importe, 'IVA'=> $IVA, 'Total'=> $Total , 'moneda'=> $moneda , 'saldo'=> $saldo , 'status'=> $status );
        
    }
     $json_string = json_encode($pedidos);
     echo  $json_string;

}






function get_token($host, $username, $password, $payloadName)
{
    $additionalHeaders = '';
    $ch = curl_init($host);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); // Execute the cURL statement
    curl_close($ch); // Close the cURL connection
    $json_token = json_decode($result, true);
    $token_received = $json_token['response']['token'];
    return ($token_received);
};

function get_dataAll($host, $token, $payloadName)
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
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($additionalHeaders));
    $result = curl_exec($ch);
    curl_close($ch);
    $json_data = json_decode($result);
    return $json_data;
};

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

function delete_token($host)
{

    $additionalHeaders = '';
    $payloadName = '';
    $ch = curl_init($host);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Specify the request method as DELETE
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); // Execute the cURL statement
    curl_close($ch); // Close the cURL connection

    // Return the result
    return ($result);
};




