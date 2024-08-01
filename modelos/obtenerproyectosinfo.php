<?php
session_start();

$contar = 0;
if (isset($_POST["pk"])) {
   
    $token= $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/proyectos_web/_find';
    $payloadName = '{
        "query": [{"pk":"' . $_POST["pk"] . '"}]
    }';

    $requestmaq = get_dataOne($host, $token, $payloadName);
    $Contarord = $requestmaq->response->dataInfo->returnedCount;

    $datos = array(); //creamos un array



    for ($i = 0; $i < $Contarord; $i++) {
        $Proyecto = $requestmaq->response->data[$i]->fieldData->{'Proyecto'};
        $fecha = $requestmaq->response->data[$i]->fieldData->{'fecha'};
        $fkCliente = $requestmaq->response->data[$i]->fieldData->{'fkCliente'};
        $cantidad = $requestmaq->response->data[$i]->fieldData->{'cantidad'};
        $producidos = $requestmaq->response->data[$i]->fieldData->{'producidos'};
        $fk_cliente_lersoft = $requestmaq->response->data[$i]->fieldData->{'fk_cliente_lersoft'};
        $fk_tipo_vagon = $requestmaq->response->data[$i]->fieldData->{'fk_tipo_vagon'};
        $producto = $requestmaq->response->data[$i]->fieldData->{'producto'};
        $pk = $requestmaq->response->data[$i]->fieldData->{'pk'};
        $datos[] = array('Proyecto'=> $Proyecto,'fecha'=> $fecha,'fkCliente'=> $fkCliente,'cantidad'=> $cantidad,'producidos'=> $producidos,'fk_cliente_lersoft'=> $fk_cliente_lersoft,'fk_tipo_vagon'=> $fk_tipo_vagon,'producto'=> $producto,'pk'=> $pk);
        
    }


     $json_string = json_encode($datos);
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


