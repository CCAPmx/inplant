<?php
require_once "conexion.php";
class ModeloProveedor
{
    static public function MdltablaProv()
    {
        $Sql = "SELECT PROVEEDOR, NOMBRE, ESTADO, CIUDAD, POBLA,COLONIA,CALLE,CP,TELEFONO,RFC,Id from proveed where activo=1";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }

}