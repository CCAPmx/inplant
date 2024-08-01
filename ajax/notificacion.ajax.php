<?php

require_once "../controladores/notificacion.controlador.php";
require_once "../modelos/notificacion.modelo.php";


class Notificacion{

  public $Combo;

  public function CbmNotificacion(){
    $respuesta = ControladorNotificacion::ctrCbmnotificacion();
    echo json_encode($respuesta); 
 }


  }
  
  if(isset($_POST["Combo"])){  
    $Usuario =  new Notificacion();
    $Usuario -> CbmNotificacion();
   }

  

  

 

       
 
