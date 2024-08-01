<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";



class TablaClientes
{

    public $Tabla;

    public function mostrarTabla()
    {
        $valor = $this->Tabla;
        $pedidos = ControladorClientes::CtrtablaPedidosClientes($valor);

        if (count($pedidos) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($pedidos); $i++) {


            $datosJson .= '[ 
            "' . $pedidos[$i]["Fecha"] . '",
            "' . $pedidos[$i]["Orden"] . '",
            "' . $pedidos[$i]["Total"] . '",
            "' . $pedidos[$i]["Moneda"] . '",
            "' . $pedidos[$i]["pk"] . '"
            
        ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   '] 

       }';

        echo $datosJson;
    }
}

if(isset($_POST["Tabla"])){
    $Seguros = new TablaClientes();
    $Seguros -> Tabla = $_POST["Tabla"];
    $Seguros -> mostrarTabla();
 }
