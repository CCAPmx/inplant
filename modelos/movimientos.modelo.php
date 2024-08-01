<?php

require_once "conexion.php";

class ModeloMov
{

    static public function MdltablaMov()
    {
        $Sql = "SELECT * FROM movimientos where estado=1";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }


}
