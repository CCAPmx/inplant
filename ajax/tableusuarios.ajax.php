<?php
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";



class TablaUsuarios
{

    public function mostrarTabla()
    {
        $Usuario = ControladorUsuarios::ctrTablaUsuarios();

        if (count($Usuario) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Usuario); $i++) {


            $datosJson .= '[ 
            "' . $Usuario[$i]["nombre"] . '",
            "' . $Usuario[$i]["usuario"] . '",
            "' . $Usuario[$i]["u_clientes"] . '",
            "' . $Usuario[$i]["id"] . '"
            
        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   '] 

       }';

        echo $datosJson;
    }
}


$mostrarDatos =  new TablaUsuarios();
$mostrarDatos->mostrarTabla();
