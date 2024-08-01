<?php

require_once "conexion.php";

class ModeloNotificacion
{

    static public function MdlCombo(){
        $Sql="SELECT
        id,
        concat(notificacion,'-', descripcion)  as text
        FROM
        niveles_alarma
        where estado=1
        ORDER BY notificacion";
    
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt -> execute();
        return $stmt -> fetchAll();
    
        $stmt = null;
    }


}