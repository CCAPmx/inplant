<?php

require_once "conexion.php";

class ModeloContacto
{

    static public function MdltablaContacto()
    {
        $Sql = "SELECT * FROM contactos where estado=1";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }


}
