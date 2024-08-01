<?php
require_once "../controladores/granulometria.controlador.php";
require_once "../modelos/granulometria.modelo.php";



class TablaGranulo
{

    public function mostrarTabla()
    {
        $Usuario = ControladorGranulo::ctrTablaGranulo();

        if (count($Usuario) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Usuario); $i++) {


            $datosJson .= '[ 
            "' . ($i + 1) . '",
            "' . $Usuario[$i]["fecha"] . '",
            "' . $Usuario[$i]["polvo"] . '",
            "' . $Usuario[$i]["c_05"] . '",
            "' . $Usuario[$i]["c_09"] . '",
            "' . $Usuario[$i]["c_150"] . '",
            "' . $Usuario[$i]["c_212"] . '",
            "' . $Usuario[$i]["c_300"] . '",
            "' . $Usuario[$i]["c_425"] . '",
            "' . $Usuario[$i]["c_600"] . '",
            "' . $Usuario[$i]["c_850"] . '",
            "' . $Usuario[$i]["c_1180"] . '",
            "' . $Usuario[$i]["c_1400"] . '",
            "' . $Usuario[$i]["c_1700"] . '",
            "' . $Usuario[$i]["c_2200"] . '",
            "' . $Usuario[$i]["id"] . '"
            
        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   '] 

       }';

        echo $datosJson;
    }
}


$mostrarDatos =  new TablaGranulo();
$mostrarDatos->mostrarTabla();
