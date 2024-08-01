<?php
require_once "../controladores/granalla.controlador.php";
require_once "../modelos/granalla.modelo.php";



class TablaGranalla
{

    public function mostrarTabla()
    {
        $Granallas = ControladorGranalla::ctrTablaGranalla();

        if (count($Granallas) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Granallas); $i++) {


            $datosJson .= '[ 
            "' . ($i + 1) . '",
            "' . $Granallas[$i]["idTipoProducto"] . '",
            "' . $Granallas[$i]["Descripcion"] . '",
            "' . $Granallas[$i]["pk"] . '",
            "' . $Granallas[$i]["codigolersoft"] . '",
            "' . $Granallas[$i]["fkCliente"] . '",
            "' . $Granallas[$i]["entradas"] . '",
            "' . $Granallas[$i]["salidas"] . '",
            "' . $Granallas[$i]["stock"] . '",
            "' . $Granallas[$i]["constante_entrada"] . '",
            "' . $Granallas[$i]["constante_salida"] . '",
            "' . $Granallas[$i]["nivel_critico"] . '",
            "' . $Granallas[$i]["demora"] . '",
            "' . $Granallas[$i]["gr_clientes"] . '",
            "' . $Granallas[$i]["id"] . '"
            
        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   '] 

       }';

        echo $datosJson;
    }
}


$mostrarDatos =  new TablaGranalla();
$mostrarDatos->mostrarTabla();
