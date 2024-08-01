<?php
require_once "../controladores/contactos.controlador.php";
require_once "../modelos/contactos.modelo.php";



class TablaContacto
{

    public function mostrarTabla()
    {
        $Contactos = ControladorContacto::ctrTablaContacto();

        if (count($Contactos) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Contactos); $i++) {


            $datosJson .= '[ 
            "' . ($i + 1) . '",
            "' . $Contactos[$i]["nombre"] . '",
            "' . $Contactos[$i]["correo"] . '",
            "' . $Contactos[$i]["id"] . '"
            
        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   '] 

       }';

        echo $datosJson;
    }
}


$mostrarDatos =  new TablaContacto();
$mostrarDatos->mostrarTabla();
