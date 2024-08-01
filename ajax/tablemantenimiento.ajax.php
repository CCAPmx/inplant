<?php
require_once "../controladores/mantenimiento.controlador.php";
require_once "../modelos/mantenimiento.modelo.php";



class TablaManto
{

    public function mostrarTabla()
    {
        $Mantos = ControladorManto::ctrTablaManto();

        if (count($Mantos) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Mantos); $i++) {


            $datosJson .= '[ 
            "' . ($i + 1) . '",
            "' . $Mantos[$i]["nombre"] . '",
            "' . $Mantos[$i]["concat"] . '",
            "' . $Mantos[$i]["id"] . '"
            
        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   '] 

       }';

        echo $datosJson;
    }
}


$mostrarDatos =  new TablaManto();
$mostrarDatos->mostrarTabla();
