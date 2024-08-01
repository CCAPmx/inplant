<?php
session_start();
// $Contars = 0;

error_reporting(0); 

date_default_timezone_set('America/Mexico_City');
header('Access-Control-Allow-Origin: *');

$input = json_decode(file_get_contents('php://input'), true);

// var_dump($input['fecha']);

if ($input['fecha'] === '0') {
    // echo 'sin datos';
    $fecha_inicio = ultimoDiaMes();
    $fecha_ultimo = ultimo_dia_mes_sin_parametros();

    
} else {

    // echo'con datos';
    $fecha = new DateTime($input['fecha']);
    $requestFechaMes = $fecha->format('m/d/Y');
    $fecha_inicio = $requestFechaMes;
    $fecha_ultimo = primerDiaMes($fecha);

    
}


// $fecha_inicio = $requestFechaMes;
// $fecha_ultimo = primerDiaMes($fecha);




// if (intval($input['fecha_inicio']) == 0) {
//     $fecha_inicio = ultimoDiaMes();
// } else {
//     $fechaInicio = new DateTime($input['fecha_inicio']);
//     $fecha_inicio = $fechaInicio->format('m/d/Y');
// }

// if (intval($input['fecha_fin']) == 0) {
//     $fecha_ultimo = primerDiaMes();
// } else {
//     $fechaFin = new DateTime($input['fecha_fin']);
//     $fecha_ultimo = $fechaFin->format('m/d/Y');
// }





// $fecha_fin = date("m/d/Y", strtotime($input['fecha_fin']));
// $fecha_inicio = date("m/d/Y", strtotime($input['fecha_inicio']));

// $fecha->format('m/d/Y')
// $fecha_inicio = $fechaInicio->format('m/d/Y');
// $fecha_ultimo = $fechaFin->format('m/d/Y');







$token = $_SESSION["ccap"];
$host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/dias_turno_web/_find';
// $body = '{
//     "query":[{
//         "t_ini":">=08/01/2023 00:00:00",
//         "t_fin":"<=08/31/2023 23:59:59"
//     }],
//      "sort":[
//        {"fieldName": "fecha","sortOrder": "ascend"}
//      ]
//    }';

$body = '{
    "query":[{
        "t_ini":">=' . $fecha_inicio . ' 00:00:00",
        "t_fin":"<=' . $fecha_ultimo . ' 23:59:59"
    }],
     "limit":"300",
     "sort":[
       {"fieldName": "fecha","sortOrder": "ascend"}
     ]
   }';


//    var_dump($body);




$requestAll = get_dataOne($host, $token, $body);



$validacion = intval($requestAll->messages[0]->code);

// var_dump($requestAll->messages);
// var_dump($requestAll);



if ($validacion == 0) {

    // echo 'tiene datos';
    $array = [
        'success' => true,
        'message' => 'Datos eventos obtenidos correctamente',
        'datosEventos' => $requestAll->response->data,
        'status' => 200,
    ];
    echo json_encode($array);
} else {
    // echo 'tiene datos no';
     $array = [
        'success' => false,
        'message' => 'Datos no optenidos correctamente favor de verificar campos',
        'status' => 400
    ];
    echo json_encode($array);
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




function ultimo_dia_mes_sin_parametros()
{

    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
    return date('m/d/Y', mktime(0, 0, 0, $month, $day, $year));
};

function primerDiaMes($requestFechaMes)
{

    $month = $requestFechaMes->format('m');
    $year = $requestFechaMes->format('Y');
    $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
    return date('m/d/Y', mktime(0, 0, 0, $month, $day, $year));
};


function ultimoDiaMes()
{
    $month = date('m');
    $year = date('Y');
    return date('m/d/Y', mktime(0, 0, 0, $month, 1, $year));
}
