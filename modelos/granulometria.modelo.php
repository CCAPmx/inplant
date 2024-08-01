<?php

require_once "conexion.php";

class ModeloGranulo
{

    static public function MdltablaGranulo()
    {
        $Sql = "SELECT * FROM granulometria where estado=1";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }


}
