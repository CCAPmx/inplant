<?php
require_once "../controladores/proveedor.controlador.php";
require_once "../modelos/proveedor.modelo.php";



class TablaProveedor{
    
  public function mostrarTabla(){
    $prov= ControladorProveedor::ctrTablaProveedor();
    
    if(count($prov) == 0){
        echo '{"data": []}';
        return;
    }

    $datosJson = '{
        "data": [';

        for($i = 0; $i < count($prov); $i++){

      

        $botones =  "<div class='btn-toolbar pull-righ' style='margin: auto; display: flex;flex-direction: row;justify-content: center;'> 
        <button type='button' class='btn mr-2 btn btn-secondary btn-xs my-2 btnedit id=".$prov[$i]["Id"]."' data-toggle='modal' data-target='#modalInformacion'>Modificar</button> 
        <button type='button' class='btn mr-2 btn btn-secondary btn-xs my-2 btndelete id=".$prov[$i]["Id"]."'>Eliminar</button>";
      
        $datosJson .='[ 
            "'.($i+1).'",
            "'.$prov[$i]["PROVEEDOR"].'",
            "'.$prov[$i]["NOMBRE"].'",
            "'.$prov[$i]["ESTADO"].'",
            "'.$prov[$i]["CIUDAD"].'",
            "'.$prov[$i]["POBLA"].'",
            "'.$prov[$i]["COLONIA"].'",
            "'.$prov[$i]["CALLE"].'",
            "'.$prov[$i]["CP"].'",
            "'.$prov[$i]["TELEFONO"].'",
            "'.$prov[$i]["RFC"].'",
            "'.$prov[$i]["Id"].'"
            
        ],';

       

        }

        $datosJson = substr($datosJson, 0, -1);

       $datosJson .=   '] 

       }';
      
      echo $datosJson;
  	


  }


}


$mostrarDatos =  new TablaProveedor();
$mostrarDatos->mostrarTabla();
