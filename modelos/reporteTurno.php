<?php
session_start();
require_once "conexion.php";

// error_reporting(0); 
if (isset($_POST["fecha"])) {
    $tablahoy = array();
    date_default_timezone_set('America/Mexico_City');

    $token = $_SESSION["ccap"];

    // var_dump($_POST["fk_cliente_lersoft"]);
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/dias_turno_supervisores_web/_find?';




    $body = '{
        "query": [
          {
            "fk_cliente": "' . $_POST["fk_cliente_lersoft"] . '",
            "fecha": "' . $_POST["fecha"] . '"
          }
        ]
      }';




    $requestAll = get_dataOne($host, $token, $body);


    // var_dump($requestAll->messages[0]->code);

    if (intval($requestAll->messages[0]->code) == 0) {
        $contador = $requestAll->response->dataInfo->foundCount;
        $tablahoy = array(); //creamos un array
        for ($i = 0; $i < $contador; $i++) {

            $fk_supervisor = $requestAll->response->data[$i]->fieldData->fk_supervisor;
            $fk_turno_supervisores = $requestAll->response->data[$i]->fieldData->fk_turno_supervisores;
            $nombre_supervisor = $requestAll->response->data[$i]->fieldData->nombre_supervisor;
            $fecha = $requestAll->response->data[$i]->fieldData->fecha;
            $hora_ini = $requestAll->response->data[$i]->fieldData->hora_ini;
            $hora_fin = $requestAll->response->data[$i]->fieldData->hora_fin;
            $t_ini = $requestAll->response->data[$i]->fieldData->t_ini;
            $t_fin = $requestAll->response->data[$i]->fieldData->t_fin;
            $nombre_maquina = $requestAll->response->data[$i]->fieldData->nombre_maquina;
            $nombre_turno = $requestAll->response->data[$i]->fieldData->nombre_turno;
            $color_turno = $requestAll->response->data[$i]->fieldData->color_turno;
            $fk_maquina = $requestAll->response->data[$i]->fieldData->fk_maquina;
            $vagones = $requestAll->response->data[$i]->fieldData->vagones;
            $hr_granallado = $requestAll->response->data[$i]->fieldData->hr_granallado;
            $kpi = $requestAll->response->data[$i]->fieldData->kpi;
            $fk_cliente = $requestAll->response->data[$i]->fieldData->fk_cliente;

            $tablahoy[] = array(
                'fk_supervisor' => $fk_supervisor,
                'fk_turno_supervisores' => $fk_turno_supervisores,
                'nombre_supervisor' => $nombre_supervisor,
                'fecha' => $fecha,
                'hora_ini' => $hora_ini,
                't_ini' => $t_ini,
                't_fin' => $t_fin,
                'fk_cliente' => $fk_cliente,
                'nombre_maquina' => $nombre_maquina,
                'nombre_turno' => $nombre_turno,
                'color_turno' => $color_turno,
                'fk_maquina' => $fk_maquina,
                'vagones' => ($vagones === "") ? 0 : $vagones,
                'hr_granallado' => ($hr_granallado === "") ? 0 :  $hr_granallado,
                'kpi' => ($kpi === "")? 0: $kpi,
                'fk_cliente' => $fk_cliente,
            );
        }

        $json_string = json_encode($tablahoy);

        // Ruta de la carpeta donde deseas guardar el archivo JSON
        $carpeta = '../vistas/recursos/json/';
    
        // Nombre del archivo JSON
        $nombreArchivo = 'reporteTurnos.json'; 
        // $nombreArchivo = 'vagones.json';    
        $rutaCompleta = $carpeta . $nombreArchivo;    
        $bytes = file_put_contents($rutaCompleta, $json_string);
    } 
    
    echo  $contador;


   


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
