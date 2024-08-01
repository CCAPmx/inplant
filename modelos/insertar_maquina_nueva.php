<?php
session_start();
date_default_timezone_set('America/Mexico_City');
header('Access-Control-Allow-Origin: *');

$token = $_SESSION["ccap"];
// var_dump($input["fk_maquina"]);

/* alta la nueva parte de la maquina */
$host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Partes_maquina_web/records';
// $h = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Partes_maquina_web/records';

$tipo = $_POST['tipo'];
$proveedor = $_POST['proveedor'];
$tipo_boquilla = (isset($_POST['tipo_boquilla'])) ? $_POST['tipo_boquilla'] : '  ';
$material_granalla = (isset($_POST['material_granalla'])) ? $_POST['material_granalla'] : '  ';
$reversible = (isset($_POST['reversible'])) ? $_POST['reversible'] : 0;
$vida_util = (isset($_POST['vida_util'])) ? $_POST['vida_util'] : '  ';
$parte = (isset($_POST['parte'])) ? $_POST['parte'] : '  ';
$Descripcion =  (isset($_POST['Descripcion'])) ? $_POST['Descripcion'] : '  ';
$comentarios = (isset($_POST['comentarios'])) ? $_POST['comentarios'] : '  ';
$noparte = $_POST['noparte'];
$nombre_maquina = $_POST['nombremaquina'];
$fkmaquina = $_POST['fkmaquina'];

$fecha =  date("d/m/Y H:i:s");

// var_dump($noparte);
// var_dump($tipo);
// var_dump($tipo_boquilla);
// var_dump($material_granalla);
// var_dump($reversible);
// var_dump($vida_util);
// var_dump($vida_util);
// var_dump($parte);
// var_dump($Descripcion);
// var_dump($comentarios);
$datos =
    '{
    "fieldData": {
        "Tipo": "'.$tipo.'",
        "fk_maquina": "'.$fkmaquina.'",
        "Descripcion": "'.$Descripcion.'",
        "No_parte": "'.$noparte.'",        
        "vida_util": '.$vida_util.',        
        "activa": 1,
        "fecha_cambio": "08/03/2023 11:12:02",        
        "usuario": "cuenta loqueada",
        "reversible": '.$reversible.',
        "volteada": 0,
        "comentarios": "'.$comentarios.'",        
        "pot_asignado": 1,
        "nombre_maquina": "'.$nombre_maquina .'",
        "tipo_descripcion": "'.$comentarios.'",
        "fkMaterial": "'.$tipo_boquilla.'",
        "fkMaterialGranalla": "'.$material_granalla.'"
    }
}';

$request = get_dataOne($host, $token, $datos);
// var_dump($request);

if (intval($request->messages[0]->code) == 0) {
    include 'baja_parte_maquina.php';
    $array = [
        'success' => true,
        'message' => 'registrado con exito',
        'status' => 200,
    ];
    echo json_encode($array);
} else {

    $array = [
        'success' => false,
        'message' => 'Error en el registro favor de validar datos',
        'error'=> $request->messages[0],
        'status' => 400
    ];
    echo json_encode($array);
}

// $contar = $requestOrden->messages;


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

// $sMetodoPago = $_POST['recordId'];




/*Primero se da de baja la parte de la maquina */
