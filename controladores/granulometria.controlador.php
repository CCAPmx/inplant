<?php
date_default_timezone_set('America/Mexico_City');
// header("Content-Type: application/json");
// var_dump(file_exists(__DIR__ . "/../modelos/MGranulometria.php"));
// var_dump(file_exists("../modelos/MGranulometria.php"));


require __DIR__ . "/../modelos/MGranulometria.php";
$action = $_GET["action"] ?? 0;
$input = json_decode(file_get_contents('php://input'), true);
// var_dump($action, $input, );


switch ($action) {
    case '1':
        $respueta = cGranulometria::dataM();
        echo json_encode($respueta);
        break;
    case 'insertar':

        $respueta = cGranulometria::insertar($input['arrayDatos'] ?? array());
        echo json_encode($respueta);
        break;

    case 'editar':
        $respueta = cGranulometria::editar($input['arrayDatos'] ?? array());
        echo json_encode($respueta);
        break;

    case 'dataGranulometria':
        $respueta = cGranulometria::dataGranulometria();
        echo json_encode($respueta);
        break;

    case 'dataGranulometriaGreenbrier':
        $respueta = cGranulometria::dataGranulometriaGreenbrier();
        echo json_encode($respueta);
        break;


    case 'dataGranulometriaGreenbrierSelector':
        $respueta = cGranulometria::dataGranulometriaGreenbrierSelector();
        echo json_encode($respueta);
        break;



    case 'insertar_reporte_greenbrier':
        $formArray = array_merge($_POST, $_FILES);
        $respueta = cGranulometria::insertarReporteGreenbrier($formArray ?? "");
        echo json_encode($respueta);
        break;


    case 'editar_reporte_greenbrier':
        $formArray = array_merge($_POST, $_FILES);
        $respueta = cGranulometria::editarReporteGreenbrier($formArray ?? "");
        echo json_encode($respueta);
        break;

    case 'crear_reporte_greenbrier':
        $formArray = array_merge($_POST, $_FILES);
        $respueta = cGranulometria::crearReporteGreenbrier($formArray ?? "");
        echo json_encode($respueta);
        break;


    case 'editar_reporte_greenbrier_autorizacion':
        $formArray = array_merge($_POST, $_FILES);
        $respueta = cGranulometria::editarReporteGreenbrierAutorizacion($formArray ?? "");
        echo json_encode($respueta);
        break;

    case 'autorizarReporteGreenbrier':
        $formArray = array_merge($_POST, $_FILES);
        $respueta = cGranulometria::autorizarReporteGreenbrier($formArray ?? "");
        echo json_encode($respueta);
        break;


    case 'dataGranulometriaReporteGreenbrier':
        $respueta = cGranulometria::dataGranulometriaReporteGreenbrier($input['arrayDatos'] ?? array());
        echo json_encode($respueta);
        break;


    case 'dataSelectorAlertasGreenbrier':
        $respueta = cGranulometria::dataSelectorAlertasGreenbrier();
        echo json_encode($respueta);
        break;


    case 'dataGranulometriaGreenbrierRecargasGranalla':

        // $input2 = json_decode(file_get_contents("php://input"), true);
        $arrayDatos = $input['arrayDatos'] ?? [];
        $maquina = $arrayDatos['maquina'] ?? null;
        // var_dump($arrayDatos, $maquina);
        $respueta = cGranulometria::dataGranulometriaGreenbrierRecargasGranalla($maquina);
        echo json_encode($respueta);
        break;

        case 'jsonDataEditarGranulometriaGreenbrierModal':

           $formArray = array_merge($_POST, $_FILES);
        //    var_dump($formArray);
        $arrayDatos = $input['arrayDatos'] ?? [];    
        $respueta = cGranulometria::jsonDataEditarGranulometriaGreenbrierModal($formArray);
        echo json_encode($respueta);
        break;  

        // default:
        //     echo json_encode(array("error" => "No se puede ejecutar la peticion", "status" => $action));
        //     break;
}


// echo json_encode(array("error" => "No se puede ejecutar la peticion", "status" => $action));
class cGranulometria
{


    static public function jsonDataEditarGranulometriaGreenbrierModal($arrayDatos)
    {
        $obj = new mainGranulometria();
        $respueta = $obj->jsonDataEditarGranulometriaGreenbrierModal($arrayDatos);
        return $respueta;
    }

    static public function dataGranulometriaGreenbrierRecargasGranalla($request)
    {

        // return $request;
        $obj = new mainGranulometria();
        $respueta = $obj->dataGranulometriaGreenbrierRecargasGranalla($request);
        return $respueta;
    }

    static public function dataSelectorAlertasGreenbrier()
    {
        $obj = new mainGranulometria();
        $respueta = $obj->dataSelectorAlertasGreenbrier();
        return $respueta;
    }

    static public function autorizarReporteGreenbrier($request)
    {
        $obj = new mainGranulometria();
        $respueta = $obj->autorizarReporteGreenbrier($request);
        return $respueta;
    }

    static public function editarReporteGreenbrierAutorizacion($request)
    {
        $obj = new mainGranulometria();
        $respueta = $obj->editarReporteGreenbrierAutorizacion($request);
        return $respueta;
    }

    static public function dataGranulometriaGreenbrierSelector()
    {
        $obj = new mainGranulometria();
        $respueta = $obj->dataGranulometriaGreenbrierSelector();
        return $respueta;
    }
    static public function dataGranulometriaReporteGreenbrier()
    {
        $obj = new mainGranulometria();
        $respueta = $obj->dataGranulometriaReporteGreenbrier();
        return $respueta;
    }
    static public function dataM()
    {
        $obj = new mainGranulometria();
        $respueta = $obj->dataMaquinas();
        return $respueta;
    }

    static public function crearReporteGreenbrier($request)
    {

        // var_dump($request);
        $obj = new mainGranulometria();
        $respueta = $obj->crearReporteGreenbrier($request);
        return $respueta;
    }

    static public function insertar($request)
    {

        // var_dump($request);
        $obj = new mainGranulometria();
        $respueta = $obj->insertar($request);
        return $respueta;
    }

    static public function insertarReporteGreenbrier($request)
    {

        // var_dump($request);
        $obj = new mainGranulometria();
        $respueta = $obj->insertarReporteGreenbrier($request);
        return $respueta;
    }

    static public function editarReporteGreenbrier($request)
    {

        // var_dump($request);
        $obj = new mainGranulometria();
        $respueta = $obj->editarReporteGreenbrier($request);
        return $respueta;
    }

    static public function dataGranulometria()
    {
        $obj = new mainGranulometria();
        $respueta = $obj->dataGranulometria();
        return $respueta;
    }


    static public function dataGranulometriaGreenbrier()
    {
        $obj = new mainGranulometria();
        $respueta = $obj->dataGranulometriaGreenbrier();
        return $respueta;
    }
    static public function editar($request)
    {
        $obj = new mainGranulometria();
        $respueta = $obj->editar($request);
        return $respueta;
    }

    //  static public function dataGranulometriaSelector($procesador)
    // {
    //     $obj = new mainGranulometria();
    //     $respueta= $obj->dataGranulometriaSelector($procesador);
    //     return $respueta;
    // }
}
