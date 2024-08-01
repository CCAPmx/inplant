<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class Usuarios{

  public $Combo;
  public $Insert;
  public $Update;
  public $Delete;
  public $Id;
  public function Insert($tabla, $Insert)
  {
    $respuesta = ControladorUsuarios::ctrInsert($tabla, $Insert);
    echo json_encode($respuesta);
  }

  public function Update($tabla, $Update)
  {
    $respuesta = ControladorUsuarios::ctrUpdate($tabla, $Update);
    echo json_encode($respuesta);
  }

  public function Cbmcat(){
    $respuesta = ControladorUsuarios::ctrCbmtipouser();
    echo json_encode($respuesta); 
 }

 public function BuscarUsuario(){
	$tabla = "usuarios";

  $item = "id";
  $valor = $this->Id;

  $respuesta = ControladorUsuarios::MostrarInfouser($tabla,$item, $valor);

  echo json_encode($respuesta);

}



  }
  
  if(isset($_POST["Combo"])){  
    $Usuario =  new Usuarios();
    $Usuario -> Cbmcat();
   }

   if (isset($_POST["Insert"])) {
    $Usuario =  new Usuarios();
    $Usuario->Insert('usuarios', $_POST["Insert"]);
  }

  if (isset($_POST["Update"])) {
    $Usuario =  new Usuarios();
    $Usuario->Update('usuarios', $_POST["Update"]);
  }
   
  if(isset($_POST["Id"])) {
    $Usuario = new Usuarios();
    $Usuario -> Id = $_POST["Id"];
    $Usuario -> BuscarUsuario();
   }

  

  

 

       
 
