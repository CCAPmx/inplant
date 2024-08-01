<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";


class Clientes
{

  public $Combo;
  public $Insert;
  public $Id;

  public function CbmCliente()
  {
    $respuesta = ControladorClientes::ctrCbmclientes();
    echo json_encode($respuesta);
  }

  public function Insert($tabla, $Insert)
  {
    $respuesta = ControladorClientes::ctrInsert($tabla, $Insert);
    echo json_encode($respuesta);
  }

  public function Delete($tabla){
    $id  = $this->Id ;
    $respuesta = ControladorClientes::ctrDelete($tabla,$id);
    echo $respuesta;
  
  }
}

if (isset($_POST["Combo"])) {
  $clientes =  new Clientes();
  $clientes->CbmCliente();
}

if (isset($_POST["Insert"])) {
  $clientes =  new Clientes();
  $clientes->Insert('tbclientes',  $_POST["Insert"]);
}

if(isset($_POST["Id"])){
  $clientes =  new Clientes();
  $clientes -> Id = $_POST["Id"];
  $clientes -> Delete('tbclientes');
}
