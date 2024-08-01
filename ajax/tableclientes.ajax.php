<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";



class TablaClientes
{

    public function mostrarTabla()
    {
        $Usuario = ControladorClientes::ctrTablaClientes();

        if (count($Usuario) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Usuario); $i++) {


            $datosJson .= '[ 
            "' . preg_replace("[\n|\r|\n\r]", "", $Usuario[$i]["Razon_social"]) . '",
            "' . preg_replace("[\n|\r|\n\r]", "", $Usuario[$i]["direccion_fiscal"]) . '",
            "' . $Usuario[$i]["RFC"] . '",
            "' . $Usuario[$i]["pk"] . '",
            "' . $Usuario[$i]["id"] . '"
            
        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   '] 

       }';

        echo $datosJson;
    }
}


$mostrarDatos =  new TablaClientes();
$mostrarDatos->mostrarTabla();
