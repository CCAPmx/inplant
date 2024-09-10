<?php
session_start();
header('Content-Type: application/json');

$contar = 0;
if (isset($_POST["pk"])) {

    $token = $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/maquinas_API_02/_find';
    // $payloadName = '{
    //     "query": [{"fk_cliente_lersoft":"' . $_POST["pk"] . '"}]
    // }';

    $payloadName = '{
        "query": [
            {
                "fk_cliente_lersoft":"' . $_POST["pk"] . '",
                "inplant_activo": "1"
            }
        ]
    }';

    $requestmaq = get_dataOne($host, $token, $payloadName);

$maquinas = array(); //creamos un array
    if (intval($requestmaq->messages[0]->code) == 0) {
        $Contarord = $requestmaq->response->dataInfo->returnedCount;
        // var_dump($Contarord);


        $maquinas = array(); //creamos un array



        for ($i = 0; $i < $Contarord; $i++) {
            $pk = $requestmaq->response->data[$i]->fieldData->{'pk'};
            $descripcion = $requestmaq->response->data[$i]->fieldData->{'descripcion'};

            $maquinas[] = array('pk' => $pk, 'descripcion' => $descripcion);
        }


        $json_string = json_encode($maquinas);
        echo  $json_string;
    } else {

        $json_string = json_encode($maquinas);
        echo  $json_string;
    }



    
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
