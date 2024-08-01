<?php

require_once "conexion.php";

class ModeloClientes
{

    static public function MdltablaClientes()
    {
        $Sql = "SELECT Razon_social,  direccion_fiscal, RFC, pk, id FROM tbclientes where estado=1";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }

    static public function MdltablaPedidosClientes($tabla)
    {
        $Sql = "SELECT pk,  Orden, Moneda, Total, Fecha FROM $tabla ";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }

    static public function MdlCombo()
    {
        $Sql = "SELECT pk as id, Razon_social as text FROM tbclientes where estado=1 and  Razon_social<>'' ORDER BY Razon_social";

        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();

        $stmt = null;
    }

    static public function Insert($tabla, $datos)
    {
        try {
            $con = Conexion::conectar();

            if ($datos['id'] == 0) {
                $stmt = $con->prepare('INSERT INTO ' . $tabla . '(pk, Nombre, email, nombrecorto, nombre_real_cliente) VALUES ( :pk, :Nombre, :email, :nombrecorto, :nombre_real_cliente)');
                $stmt->bindParam(':pk', $datos['pk'], PDO::PARAM_STR);
                $stmt->bindParam(':Nombre', $datos['Nombre'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $datos['email'], PDO::PARAM_STR);
                $stmt->bindParam(':nombrecorto', $datos['nombrecorto'], PDO::PARAM_STR);
                $stmt->bindParam(':nombre_real_cliente', $datos['nombre_real_cliente'], PDO::PARAM_STR);
            } elseif ($datos['id'] != 0) {
                $stmt = $con->prepare('UPDATE ' . $tabla . ' SET pk=:pk, Nombre=:Nombre, email=:email, nombrecorto=:nombrecorto, nombre_real_cliente=:nombre_real_cliente WHERE id=:id');
                $stmt->bindParam(':id', $datos['id'], PDO::PARAM_INT);
                $stmt->bindParam(':pk', $datos['pk'], PDO::PARAM_STR);
                $stmt->bindParam(':Nombre', $datos['Nombre'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $datos['email'], PDO::PARAM_STR);
                $stmt->bindParam(':nombrecorto', $datos['nombrecorto'], PDO::PARAM_STR);
                $stmt->bindParam(':nombre_real_cliente', $datos['nombre_real_cliente'], PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $lastInsertId = 1;
            } else {
                $lastInsertId = 0;
            }
            return $lastInsertId;
            $stmt = null;
            $con = null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

    static public function Delete($tabla, $Id){
        $stmt = Conexion::conectar()->prepare('UPDATE ' . $tabla . ' SET estado=0 WHERE id=' . $Id . ' and estado=1');
        $stmt->execute();
        $count =$stmt->rowCount();
        return $count;
        $stmt = null;
    }

}
