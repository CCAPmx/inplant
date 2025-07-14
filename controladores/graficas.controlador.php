<?php
date_default_timezone_set('America/Mexico_City');}
header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json");
// var_dump(file_exists(__DIR__ . "/../modelos/MGranulometria.php"));
// var_dump(file_exists("../modelos/MGranulometria.php"));


require __DIR__ . "/../modelos/MGranulometria.php";
$action = $_GET["action"] ?? 0;
$input = json_decode(file_get_contents('php://input'), true);



switch ($action) {
    case 'graficaGrano':


        // $respueta = cGranulometria::dataM();
        echo json_encode($input);
        // break;
    case 'insertar':

        $respueta = cGranulometria::insertar($input['arrayDatos'] ?? array());
        echo json_encode($input);
        break;

    

        // default:
        //     echo json_encode(array("error" => "No se puede ejecutar la peticion", "status" => $action));
        //     break;
}


// echo json_encode(array("error" => "No se puede ejecutar la peticion", "status" => $action));
class cGraficas
{


    static public function dataGranulometriaGreenbrierRecargasGranalla($request)
    {

        // return $request;
        $obj = new mainGranulometria();
        $respueta = $obj->dataGranulometriaGreenbrierRecargasGranalla($request);
        return $respueta;
    }

}
