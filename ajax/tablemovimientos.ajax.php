<?php
require_once "../controladores/movimientos.controlador.php";
require_once "../modelos/movimientos.modelo.php";



class TablaMov
{

    public function mostrarTabla()
    {
        $Movs = ControladorMov::ctrTablaMov();

        if (count($Movs) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Movs); $i++) {


            $datosJson .= '[ 
            "' . ($i + 1) . '",
            "' . $Movs[$i]["tipo"] . '",
            "' . $Movs[$i]["cantidad"] . '",
            "' . $Movs[$i]["usuario"] . '",
            "' . $Movs[$i]["id"] . '"
            
        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   '] 

       }';

        echo $datosJson;
    }
}


$mostrarDatos =  new TablaMov();
$mostrarDatos->mostrarTabla();
