<?php
date_default_timezone_set('America/Mexico_City');
// header("Content-Type: application/json");
// var_dump(file_exists(__DIR__ . "/../modelos/MGranulometria.php"));
// var_dump(file_exists("../modelos/MGranulometria.php"));


require __DIR__ . "/../modelos/MGranulometria.php";
$action = $_GET["action"] ?? 0;
$input = json_decode(file_get_contents('php://input'), true);
// var_dump($action, $input);


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
}


// echo json_encode(array("error" => "No se puede ejecutar la peticion", "status" => $action));
class cGranulometria
{
    static public function dataM()
    {
        $obj = new mainGranulometria();
        $respueta = $obj->dataMaquinas();
        return $respueta;
    }

    static public function insertar($request)
    {

        // var_dump($request);
        $obj = new mainGranulometria();
        $respueta = $obj->insertar($request);
        return $respueta;
    }

    static public function dataGranulometria()
    {
        $obj = new mainGranulometria();
        $respueta = $obj->dataGranulometria();
        return $respueta;
    }
    static public function editar($request)
    {
        $obj = new mainGranulometria();
        $respueta = $obj->editar($request);
        return $respueta;
    }
}
