<?php
date_default_timezone_set('America/Mexico_City');
class ControladorClientes
{
 
    static public function ctrTablaClientes()
    {
        $respueta= ModeloClientes::MdltablaClientes();
        return $respueta;
    }

    static public function CtrtablaPedidosClientes($tabla)
    {
        $respueta= ModeloClientes::MdltablaPedidosClientes($tabla);
        return $respueta;
    }

    static public function ctrCbmclientes()
    {
        $respuesta = ModeloClientes::MdlCombo();
        return $respuesta ; 
    }

    static public function ctrInsert($tabla, $datosInsert)
	{
		if (isset($datosInsert["pk"])) {
			$datos = array(
                "id" => $datosInsert["id"],
				"pk" => $datosInsert["pk"],
				"Nombre" => $datosInsert["Nombre"],
				"email" => $datosInsert["email"],
				"nombrecorto" => $datosInsert["nombrecorto"],
				"nombre_real_cliente" => $datosInsert["nombre_real_cliente"]
			);
			$respuesta = ModeloClientes::Insert($tabla, $datos);
			return $respuesta;
		}
	}

    static public function ctrDelete($tabla,$Id){
        $respuesta = ModeloClientes::Delete($tabla,$Id);
        return $respuesta ; 
    }
 
}
