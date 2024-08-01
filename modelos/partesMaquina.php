<?php
session_start();
require_once "conexion.php";


date_default_timezone_set('America/Mexico_City');
header('Access-Control-Allow-Origin: *');
$input = json_decode(file_get_contents('php://input'), true);
$tablahoy = array();
date_default_timezone_set('America/Mexico_City');

$token = $_SESSION["ccap"];
// var_dump($input["fk_maquina"]);
$host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Partes_maquina_web/_find?';
$body = '
    {
        "query": [
            {
                           
                "fk_maquina": "' . $input["fk_maquina"] . '",
                "activa":1    
            }
        ]
    }
        ';
$requestAll = get_dataOne($host, $token, $body);
// var_dump($requestAll->response->data[0]->recordId);
// var_dump($requestAll->messages[0]->code);
if (intval($requestAll->messages[0]->code) == 0) {

    $contador = $requestAll->response->dataInfo->foundCount;
    $tablahoy = array(); //creamos un array
    for ($i = 0; $i < $contador; $i++) {

        $Tipo = $requestAll->response->data[$i]->fieldData->tipo_descripcion;
        $fk_maquina = $requestAll->response->data[$i]->fieldData->fk_maquina;
        $Descripcion = $requestAll->response->data[$i]->fieldData->Descripcion;
        $No_parte = $requestAll->response->data[$i]->fieldData->No_parte;
        $horometro = $requestAll->response->data[$i]->fieldData->horometro;
        $vida_util = $requestAll->response->data[$i]->fieldData->vida_util;
        $pk = $requestAll->response->data[$i]->fieldData->pk;
        $porcentaje_cambio = $requestAll->response->data[$i]->fieldData->porcentaje_cambio;
        $porcentaje_revision = $requestAll->response->data[$i]->fieldData->porcentaje_revision;
        $activa = $requestAll->response->data[$i]->fieldData->activa;
        $fecha_cambio = $requestAll->response->data[$i]->fieldData->fecha_cambio;
        $vida_util_real = $requestAll->response->data[$i]->fieldData->vida_util_real;
        $vagousuariones = $requestAll->response->data[$i]->fieldData->usuario;
        $reversible = $requestAll->response->data[$i]->fieldData->reversible;
        $volteada = $requestAll->response->data[$i]->fieldData->volteada;
        $comentarios = $requestAll->response->data[$i]->fieldData->comentarios;
        $horastrabajadas = $requestAll->response->data[$i]->fieldData->horastrabajadas;
        $pot_asignado = $requestAll->response->data[$i]->fieldData->pot_asignado;
        $nombre_maquina = $requestAll->response->data[$i]->fieldData->nombre_maquina;
        $recordId = $requestAll->response->data[$i]->recordId;

        $tablahoy[] = array(
            'tipo' => $Tipo,
            'fk_maquina' => $fk_maquina,
            'Descripcion' => $Descripcion,
            'horometro' => $horometro,
            'vida_util' => $vida_util,
            'vida_util_real' => $vida_util_real,
            'pk' => $pk,
            'porcentaje_cambio' => $porcentaje_cambio . ' %',
            'porcentaje_revision' => $porcentaje_revision,
            'activa' => $activa,
            'fecha_cambio' => $fecha_cambio,
            'vagousuariones' => $vagousuariones,
            'reversible' => $reversible,
            'volteada' => $volteada,
            'comentarios' => $comentarios,
            'horastrabajadas' => $horastrabajadas,
            'pot_asignado' => $horastrabajadas,
            'nombre_maquina' => $horastrabajadas,
            'acciones' => '<button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="'.$pk.'" data-bs-maquina="'.$fk_maquina.'"
             style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i class="fa-solid fa-plus"></i></button>

             <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#Editar"  data-bs-recordId="'.$recordId.'" data-bs-pk="'.$pk.'" data-bs-noparte="'.$No_parte.'" data-bs-nombremaquina="'.$nombre_maquina.'"
             data-bs-nombremaquina="'.$nombre_maquina.'" data-bs-fkmaquina="'.$fk_maquina.'"
             style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i class="fa-regular fa-pen-to-square"></i></button>
             '
        );
    }

    $json_string = json_encode($tablahoy);

    // Ruta de la carpeta donde deseas guardar el archivo JSON
    $carpeta = '../vistas/recursos/json/';

    // Nombre del archivo JSON
    $nombreArchivo = 'partesMaquinas.json';
    // $nombreArchivo = 'vagones.json';    
    $rutaCompleta = $carpeta . $nombreArchivo;
    $bytes = file_put_contents($rutaCompleta, $json_string);

    echo  $contador;
} else {
    echo 0;
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
