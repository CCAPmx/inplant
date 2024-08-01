<?php

require_once "conexion.php";

class ModeloGranalla
{

    static public function MdltablaGranalla()
    {
        $Sql = "SELECT * FROM granalla where estado=1";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }


}
