<?php

require_once "conexion.php";

class ModeloUsuarios
{

    static public function MdltablaUsuarios()
    {
        $Sql = "SELECT * From usuarios where usuarios.estado=1";
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt = null;
    }

    static public function MdlMostrarUsuariosmod($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT
            usuarios.pk as pkuser,
            usuarios.nombre, 
            usuarios.usuario, 
            usuarios.password, 
            tiposusuarios.nombre AS tipouser, 
            niveles_alarma.notificacion, 
            usuarios.u_clientes, 
            usuarios.id, 
            usuarios.tipousuarionivel, 
            usuarios.tipousuarionombre, 
            usuarios.estado, 
            usuarios.fkEmpresa, 
            tbclientes.Codigo, 
            tbclientes.Razon_social, 
            tbclientes.direccion_fiscal, 
            tbclientes.RFC, 
            tbclientes.pk,
            usuarios.produccion,
            usuarios.mantenimiento,
            usuarios.bodega,
            usuarios.maquinas
        FROM
            usuarios
            INNER JOIN
            tiposusuarios
            ON 
                usuarios.fkTipo = tiposusuarios.pk
            INNER JOIN
            niveles_alarma
            ON 
                usuarios.nivel_alarmas = niveles_alarma.id
            INNER JOIN
            tbclientes
            ON 
                usuarios.fkEmpresa = tbclientes.pk WHERE $item =:$item");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        }
        $stmt = null;
    }

    static public function MdlCombo(){
        $Sql="SELECT
        pk as id,
        nombre as text
        FROM
        tiposusuarios
        where estado=1
        ORDER BY nombre";
    
        $stmt = Conexion::conectar()->prepare($Sql);
        $stmt -> execute();
        return $stmt -> fetchAll();
    
        $stmt = null;
    }

    static public function mdlIngresarUsuario($tabla, $datos)
    {
        try { 

        $encriptar = crypt($datos['password'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
        $stmt = Conexion::conectar() -> prepare("INSERT INTO $tabla (pk,usuario,nombre,fkEmpresa,activo,fkTipo,produccion,mantenimiento,bodega,maquinas,password,device,cambiodispositivo,cambiopassword,tipousuarionombre,tipousuarionivel,token,telefono,lada,telefono_app,nivel_alarmas,ext_cargarGranalla,ext_cargarpiezas,ext_altapartes,ext_vidautil,ext_entradas,ext_salidas,fotos,u_clientes,ext_preparacion,ext_granallado,ext_calidad,vagones) 
        VALUES(:pk,:usuario,:nombre,:fkEmpresa,:activo,:fkTipo,:produccion,:mantenimiento,:bodega,:maquinas,:password,:device,:cambiodispositivo,:cambiopassword,:tipousuarionombre,:tipousuarionivel,:token,:telefono,:lada,:telefono_app,:nivel_alarmas,:ext_cargarGranalla,:ext_cargarpiezas,:ext_altapartes,:ext_vidautil,:ext_entradas,:ext_salidas,:fotos,:u_clientes,:ext_preparacion,:ext_granallado,:ext_calidad,:vagones)");
        $stmt->bindParam(":pk", $datos["pk"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":fkEmpresa", $datos["fkEmpresa"], PDO::PARAM_STR);
        $stmt->bindParam(":activo", $datos["activo"], PDO::PARAM_INT);
        $stmt->bindParam(":fkTipo", $datos["fkTipo"], PDO::PARAM_STR);
        $stmt->bindParam(":produccion", $datos["produccion"], PDO::PARAM_INT);
        $stmt->bindParam(":mantenimiento", $datos["mantenimiento"], PDO::PARAM_INT);
        $stmt->bindParam(":bodega", $datos["bodega"], PDO::PARAM_INT);
        $stmt->bindParam(":maquinas", $datos["maquinas"], PDO::PARAM_INT);
        $stmt->bindParam(":password", $encriptar, PDO::PARAM_STR);
        $stmt->bindParam(":device", $datos["device"], PDO::PARAM_STR);
        $stmt->bindParam(":cambiodispositivo", $datos["cambiodispositivo"], PDO::PARAM_INT);
        $stmt->bindParam(":cambiopassword", $datos["cambiopassword"], PDO::PARAM_INT);
        $stmt->bindParam(":tipousuarionombre", $datos["tipousuarionombre"], PDO::PARAM_STR);
        $stmt->bindParam(":tipousuarionivel", $datos["tipousuarionivel"], PDO::PARAM_STR);
        $stmt->bindParam(":token", $datos["token"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":lada", $datos["lada"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_app", $datos["telefono_app"], PDO::PARAM_STR);
        $stmt->bindParam(":nivel_alarmas", $datos["nivel_alarmas"], PDO::PARAM_INT);
        $stmt->bindParam(":ext_cargarGranalla", $datos["ext_cargarGranalla"], PDO::PARAM_INT);
        $stmt->bindParam(":ext_cargarpiezas", $datos["ext_cargarpiezas"], PDO::PARAM_INT);
        $stmt->bindParam(":ext_altapartes", $datos["ext_altapartes"], PDO::PARAM_INT);
        $stmt->bindParam(":ext_vidautil", $datos["ext_vidautil"], PDO::PARAM_INT);
        $stmt->bindParam(":ext_entradas", $datos["ext_entradas"], PDO::PARAM_INT);
        $stmt->bindParam(":ext_salidas", $datos["ext_salidas"], PDO::PARAM_INT);
        $stmt->bindParam(":fotos", $datos["fotos"], PDO::PARAM_INT);
        $stmt->bindParam(":u_clientes", $datos["u_clientes"], PDO::PARAM_STR);
        $stmt->bindParam(":ext_preparacion", $datos["ext_preparacion"], PDO::PARAM_INT);
        $stmt->bindParam(":ext_granallado", $datos["ext_granallado"], PDO::PARAM_INT);
        $stmt->bindParam(":ext_calidad", $datos["ext_calidad"], PDO::PARAM_INT);
        $stmt->bindParam(":vagones", $datos["vagones"], PDO::PARAM_INT);
        
        if($stmt->execute()){
             return 1;
        }else{
            return 0 ;
        }
        $stmt = null;
    } catch (PDOException $e) {
       
        return 0;
    }
    }


    static public function mdlUpdateUsuario($tabla, $datos)
    {
        try { 
        if ($datos['password']==""){
            $stmt = Conexion::conectar() -> prepare("UPDATE $tabla SET pk=:pk,usuario=:usuario,nombre=:nombre,fkEmpresa=:fkEmpresa,activo=:activo,fkTipo=:fkTipo,produccion=:produccion, 
            mantenimiento=:mantenimiento,bodega=:bodega,maquinas=:maquinas,device=:device,cambiodispositivo=:cambiodispositivo,cambiopassword=:cambiopassword,tipousuarionombre=:tipousuarionombre, 
            tipousuarionivel=:tipousuarionivel,token=:token,telefono=:telefono,lada=:lada,telefono_app=:telefono_app,nivel_alarmas=:nivel_alarmas,ext_cargarGranalla=:ext_cargarGranalla, 
            ext_cargarpiezas=:ext_cargarpiezas,ext_altapartes=:ext_altapartes,ext_vidautil=:ext_vidautil,ext_entradas=:ext_entradas,ext_salidas=:ext_salidas,fotos=:fotos,u_clientes=:u_clientes, 
            ext_preparacion=:ext_preparacion,ext_granallado=:ext_granallado,ext_calidad=:ext_calidad,vagones=:vagones WHERE id = :id");
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $stmt->bindParam(":pk", $datos["pk"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":fkEmpresa", $datos["fkEmpresa"], PDO::PARAM_STR);
            $stmt->bindParam(":activo", $datos["activo"], PDO::PARAM_INT);
            $stmt->bindParam(":fkTipo", $datos["fkTipo"], PDO::PARAM_STR);
            $stmt->bindParam(":produccion", $datos["produccion"], PDO::PARAM_INT);
            $stmt->bindParam(":mantenimiento", $datos["mantenimiento"], PDO::PARAM_INT);
            $stmt->bindParam(":bodega", $datos["bodega"], PDO::PARAM_INT);
            $stmt->bindParam(":maquinas", $datos["maquinas"], PDO::PARAM_INT);
            $stmt->bindParam(":device", $datos["device"], PDO::PARAM_STR);
            $stmt->bindParam(":cambiodispositivo", $datos["cambiodispositivo"], PDO::PARAM_INT);
            $stmt->bindParam(":cambiopassword", $datos["cambiopassword"], PDO::PARAM_INT);
            $stmt->bindParam(":tipousuarionombre", $datos["tipousuarionombre"], PDO::PARAM_STR);
            $stmt->bindParam(":tipousuarionivel", $datos["tipousuarionivel"], PDO::PARAM_STR);
            $stmt->bindParam(":token", $datos["token"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(":lada", $datos["lada"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono_app", $datos["telefono_app"], PDO::PARAM_STR);
            $stmt->bindParam(":nivel_alarmas", $datos["nivel_alarmas"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_cargarGranalla", $datos["ext_cargarGranalla"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_cargarpiezas", $datos["ext_cargarpiezas"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_altapartes", $datos["ext_altapartes"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_vidautil", $datos["ext_vidautil"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_entradas", $datos["ext_entradas"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_salidas", $datos["ext_salidas"], PDO::PARAM_INT);
            $stmt->bindParam(":fotos", $datos["fotos"], PDO::PARAM_INT);
            $stmt->bindParam(":u_clientes", $datos["u_clientes"], PDO::PARAM_STR);
            $stmt->bindParam(":ext_preparacion", $datos["ext_preparacion"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_granallado", $datos["ext_granallado"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_calidad", $datos["ext_calidad"], PDO::PARAM_INT);
            $stmt->bindParam(":vagones", $datos["vagones"], PDO::PARAM_INT);
        }else{
            $encriptar = crypt($datos['password'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            $stmt = Conexion::conectar() -> prepare("UPDATE $tabla SET pk=:pk,usuario=:usuario,nombre=:nombre,fkEmpresa=:fkEmpresa,activo=:activo,fkTipo=:fkTipo,produccion=:produccion, 
            mantenimiento=:mantenimiento,bodega=:bodega,maquinas=:maquinas,password=:password,device=:device,cambiodispositivo=:cambiodispositivo,cambiopassword=:cambiopassword,tipousuarionombre=:tipousuarionombre, 
            tipousuarionivel=:tipousuarionivel,token=:token,telefono=:telefono,lada=:lada,telefono_app=:telefono_app,nivel_alarmas=:nivel_alarmas,ext_cargarGranalla=:ext_cargarGranalla, 
            ext_cargarpiezas=:ext_cargarpiezas,ext_altapartes=:ext_altapartes,ext_vidautil=:ext_vidautil,ext_entradas=:ext_entradas,ext_salidas=:ext_salidas,fotos=:fotos,u_clientes=:u_clientes, 
            ext_preparacion=:ext_preparacion,ext_granallado=:ext_granallado,ext_calidad=:ext_calidad,vagones=:vagones WHERE id = :id");
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $stmt->bindParam(":pk", $datos["pk"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":fkEmpresa", $datos["fkEmpresa"], PDO::PARAM_STR);
            $stmt->bindParam(":activo", $datos["activo"], PDO::PARAM_INT);
            $stmt->bindParam(":fkTipo", $datos["fkTipo"], PDO::PARAM_STR);
            $stmt->bindParam(":produccion", $datos["produccion"], PDO::PARAM_INT);
            $stmt->bindParam(":mantenimiento", $datos["mantenimiento"], PDO::PARAM_INT);
            $stmt->bindParam(":bodega", $datos["bodega"], PDO::PARAM_INT);
            $stmt->bindParam(":maquinas", $datos["maquinas"], PDO::PARAM_INT);
            $stmt->bindParam(":password", $encriptar, PDO::PARAM_STR);
            $stmt->bindParam(":device", $datos["device"], PDO::PARAM_STR);
            $stmt->bindParam(":cambiodispositivo", $datos["cambiodispositivo"], PDO::PARAM_INT);
            $stmt->bindParam(":cambiopassword", $datos["cambiopassword"], PDO::PARAM_INT);
            $stmt->bindParam(":tipousuarionombre", $datos["tipousuarionombre"], PDO::PARAM_STR);
            $stmt->bindParam(":tipousuarionivel", $datos["tipousuarionivel"], PDO::PARAM_STR);
            $stmt->bindParam(":token", $datos["token"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(":lada", $datos["lada"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono_app", $datos["telefono_app"], PDO::PARAM_STR);
            $stmt->bindParam(":nivel_alarmas", $datos["nivel_alarmas"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_cargarGranalla", $datos["ext_cargarGranalla"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_cargarpiezas", $datos["ext_cargarpiezas"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_altapartes", $datos["ext_altapartes"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_vidautil", $datos["ext_vidautil"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_entradas", $datos["ext_entradas"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_salidas", $datos["ext_salidas"], PDO::PARAM_INT);
            $stmt->bindParam(":fotos", $datos["fotos"], PDO::PARAM_INT);
            $stmt->bindParam(":u_clientes", $datos["u_clientes"], PDO::PARAM_STR);
            $stmt->bindParam(":ext_preparacion", $datos["ext_preparacion"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_granallado", $datos["ext_granallado"], PDO::PARAM_INT);
            $stmt->bindParam(":ext_calidad", $datos["ext_calidad"], PDO::PARAM_INT);
            $stmt->bindParam(":vagones", $datos["vagones"], PDO::PARAM_INT);

        }
      
        
        if($stmt->execute()){
             return 1;
        }else{
            return 0 ;
        }
        $stmt = null;
    } catch (PDOException $e) {
       
        return 0;
    }
    }


    static public function MdlMostrarInfouser($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT id, nombre, usuario, fkTipo as tipousuario, fkEmpresa as idempresa, nivel_alarmas, telefono_app, produccion, mantenimiento, bodega,
            ext_cargarGranalla,ext_cargarpiezas, ext_altapartes, ext_vidautil, ext_entradas, ext_salidas, maquinas from $tabla WHERE $item =:$item");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();

            var_dump($stmt->fetch());
        }
        $stmt = null;
    }


}