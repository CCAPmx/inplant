<?php
require_once "../controladores/maquinas.controlador.php";
require_once "../modelos/maquinas.modelo.php";



class TablaMaquinas
{

    public function mostrarTabla()
    {
        $Maquinass = ControladorMaquinas::ctrTablaMaquinas();

        if (count($Maquinass) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Maquinass); $i++) {


            $datosJson .= '[ 
            "' . ($i + 1) . '",
            "' . $Maquinass[$i]["nombre"] . '",
            "' . $Maquinass[$i]["concats"] . '",
            "' . $Maquinass[$i]["pk"] . '",
            "' . $Maquinass[$i]["id"] . '"
            
        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   '] 

       }';

        echo $datosJson;
    }
}


$mostrarDatos =  new TablaMaquinas();
$mostrarDatos->mostrarTabla();
