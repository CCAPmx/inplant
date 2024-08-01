<?php

require_once "conexion.php";

class ModeloManto
{

    static public function MdltablaManto()
    {
        $Sql = "SELECT id, pk, nombre, concat from maquinas_api where estado=1";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }


}
