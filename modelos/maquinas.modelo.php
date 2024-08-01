<?php

require_once "conexion.php";

class ModeloMaquinas
{

    static public function MdltablaMaquinas()
    {
        $Sql = "SELECT nombre, concat as concats, pk,id FROM maquinas_api where estado=1";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }


}
