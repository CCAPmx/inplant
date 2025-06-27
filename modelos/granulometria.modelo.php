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



    static public function dataGranulometria($procesador)
    {
        $Sql = "SELECT * FROM granulometrias
        WHERE fecha >= NOW() - INTERVAL 5 DAY
        ORDER BY fecha DESC
        LIMIT 5;
        ";

        
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }

     
}
