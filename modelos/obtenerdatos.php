<?php
session_start();

$contar = 0;
if (isset($_POST["nombre"])) {
   
    $token= $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/maquinas_API_sencillo/_find';
    $payloadName = '{
        "query": [{"nombre":"' . $_POST["nombre"] . '"}]
    }';

    $requestmaq = get_dataOne($host, $token, $payloadName);
    $Contarord = $requestmaq->response->dataInfo->returnedCount;

    $maquinas = array(); //creamos un array



    for ($i = 0; $i < $Contarord; $i++) {
        $nombre = $requestmaq->response->data[$i]->fieldData->{'nombre'};
        $maquina = $requestmaq->response->data[$i]->fieldData->{'concat'};
        $turbinas = $requestmaq->response->data[$i]->fieldData->{'no_turbinas_activas'};
        $voltaje = $requestmaq->response->data[$i]->fieldData->{'voltaje'};
        $producto = $requestmaq->response->data[$i]->fieldData->{'producto'};
        $abrasivo = $requestmaq->response->data[$i]->fieldData->{'abrasivo'};
        $produccion = $requestmaq->response->data[$i]->fieldData->{'perf_hora'};
        $ampmax = $requestmaq->response->data[$i]->fieldData->{'max_amperaje'};
        $ampideal = $requestmaq->response->data[$i]->fieldData->{'amp_ideal'};
        $ampcritico = $requestmaq->response->data[$i]->fieldData->{'min_amperaje'};
        $ampvacio = $requestmaq->response->data[$i]->fieldData->{'amperaje_vacio'};
        $potenciatot = $requestmaq->response->data[$i]->fieldData->{'potencia'};
        $consumoabra = $requestmaq->response->data[$i]->fieldData->{'consumo_granalla_hora'};
        $costogranalla = $requestmaq->response->data[$i]->fieldData->{'costo_granalla'};
        $costoelectrico = $requestmaq->response->data[$i]->fieldData->{'costo_electrico'};
        $costopersonal = $requestmaq->response->data[$i]->fieldData->{'costo_personal'};
        $operadores = $requestmaq->response->data[$i]->fieldData->{'tiempolectura'};
        $costomonto = $requestmaq->response->data[$i]->fieldData->{'costo_mtto_maquina'};
        $maquinas[] = array('nombre'=> $nombre, 'maquina'=> $maquina, 'turbinas'=> $turbinas, 'voltaje'=> $voltaje, 'producto'=> $producto, 'abrasivo'=> $abrasivo, 'produccion'=> $produccion, 
        'ampmax'=> $ampmax, 'ampideal'=> $ampideal, 'ampcritico'=> $ampcritico, 'ampvacio'=> $ampvacio, 'potenciatot'=> $potenciatot, 'consumoabra'=> $consumoabra, 
        'costogranalla'=> $costogranalla, 'costoelectrico'=> $costoelectrico, 'costopersonal'=> $costopersonal, 'operadores'=> $operadores, 'costomonto'=> $costomonto);
        
    }


     $json_string = json_encode($maquinas);
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




