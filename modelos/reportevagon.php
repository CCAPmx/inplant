<?php
session_start();
require_once "conexion.php";

// error_reporting(0); 
if (isset($_POST["fecha"])) {
    $tablahoy = array();
    date_default_timezone_set('America/Mexico_City');

    $token= $_SESSION["ccap"];

    // var_dump($_POST["fk_cliente_lersoft"]);
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/vagones_web_detalle/_find?';
    
    
    $payloadName  = '
    {
        "query": [
            {
                "fkCliente": "'. $_POST["fk_cliente_lersoft"] .'",
                "fecha_api": "'.$_POST["fecha"].'",
                "flag_regranallado": 0
            }
        ],
        "limit": "1"
    }
    ';

    $requestAll2 = get_dataOne($host,$token,$payloadName) ;  

    // var_dump($payloadName);
    // var_dump($requestAll2);
    $Contar = $requestAll2->response->dataInfo->foundCount;

    $payloadName2  = '
    {
        "query": [
            {
                "fecha_api": "'. $_POST["fecha"] .'",
                "fkCliente": "'. $_POST["fk_cliente_lersoft"] .'",
                "flag_regranallado": 0
            }
        ],
        "limit": "'.$Contar.'",
        "sort": [
            {
                "fieldName": "consecutivo_cabina",
                "sortOrder": "descend",
                "fieldName": "fecha_api",
                "sortOrder": "descend"
            }
        ]
    }
    ';   


    $requestAll = get_dataOne($host,$token,$payloadName2); 
   

   
    // var_dump($requestAll->response->data[0]);
    // var_dump($requestAll2);

    
    
    // $payloadName = '{"query": [{"fecha_api": "'. $_POST["fecha"] .'","fk_cliente_lersoft": "'. $_POST["fk_cliente_lersoft"] .'", "flag_regranallado":0}],
    // "sort":[{"fieldName": "consecutivo_cabina","sortOrder": "descend","fieldName": "fecha_api","sortOrder": "descend"}]}';

    // $payloadName = '{"query": [{"fecha_api": "'. $_POST["fecha"] .'"}],
    // "sort":[{"fieldName": "consecutivo_cabina","sortOrder": "descend","fieldName": "fecha_api","sortOrder": "descend"}]}';


    
     
   
    $tablahoy = array(); //creamos un array
         for ($i = 0; $i < $Contar; $i++) {
            $status="";
           $alias_produccion=$requestAll->response->data[$i]->fieldData->alias_produccion;
           $fk_maquina=$requestAll->response->data[$i]->fieldData->{'fk_maquina'};
           $fkProducto=$requestAll->response->data[$i]->fieldData->{'fkProducto'};
           $flag_granallado=$requestAll->response->data[$i]->fieldData->{'flag_granallado'};
           $fk_proyecto=$requestAll->response->data[$i]->fieldData->{'fk_proyecto'};
           $serie_proyecto=$requestAll->response->data[$i]->fieldData->{'serie_proyecto'};
           $consecutivo_cabina=$requestAll->response->data[$i]->fieldData->{'consecutivo_cabina'};
           $fkCliente=$requestAll->response->data[$i]->fieldData->{'fkCliente'};
           $fk_cliente_lersoft=$requestAll->response->data[$i]->fieldData->{'fk_cliente_lersoft'};
           $nombre_cabina=$requestAll->response->data[$i]->fieldData->{'nombre_cabina'};
           $fecha_granallado=$requestAll->response->data[$i]->fieldData->{'fecha_granallado'};
           $supervisor=$requestAll->response->data[$i]->fieldData->{'supervisor'};
            if ($fecha_granallado==""){
             $fecha_granallado="N/A";
            }
           if ($consecutivo_cabina==-1){
            $status="Granallado Terminado";
           }elseif($consecutivo_cabina==0){
            $status="En Cabina";
           }elseif($consecutivo_cabina==1){
            $status="En Espera";
           }
           
           $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
           $veces_regranallado=$requestAll->response->data[$i]->fieldData->{'veces_regranallado'};
           if ( $veces_regranallado==0){
            $veces_regranallado="";
           }

           if ($fecha_granallado=="N/A"){
            
           $mifecha ="N/A";
           }else{
            $mifecha = new DateTime($fecha_granallado);
            $mifecha = $mifecha->format('d/m/Y');
           }

           

           

        //    if ($fecha_granallado!=""){
        //    $mifecha = new DateTime($fecha_granallado);
        //    $mifecha = $mifecha->format('d/m/Y');
        // }
           $tablahoy[] = array(
            'alias_produccion'=> $alias_produccion, 
            'fk_maquina'=> $fk_maquina, 
            'fkProducto'=> $fkProducto, 
            'flag_granallado'=> $flag_granallado, 
           'fk_proyecto'=> $fk_proyecto, 
           'serie_proyecto'=> $serie_proyecto, 
           'consecutivo_cabina'=> $consecutivo_cabina, 
           'fkCliente'=> $fkCliente, 
           'fk_cliente_lersoft'=> $fk_cliente_lersoft , 
           'nombre_cabina'=> $nombre_cabina, 
           'fecha_granallado'=> $mifecha, 
           'status'=> $status, 'pk'=> $pk, 
           'veces_regranallado'=> $veces_regranallado,
           'supervisor'=> $supervisor
        );
      
      }

        $json_string = json_encode($tablahoy);

    

        // // Ruta de la carpeta donde deseas guardar el archivo JSON
         $carpeta = '../vistas/recursos/json/';

        // // Nombre del archivo JSON
         $nombreArchivo = 'vagones.json';

         $rutaCompleta = $carpeta . $nombreArchivo;


         $bytes = file_put_contents($rutaCompleta, $json_string); 

        // // Ruta completa del archivo
        //
        // // Intenta guardar el archivo JSON en la carpeta
        // if (file_put_contents($rutaCompleta, $json_string)) {
        //     echo 'Archivo JSON creado y guardado exitosamente.';
        // } else {
        //     echo 'Hubo un error al intentar guardar el archivo JSON.';
        // }


        echo  $Contar;

     
    //   $json_string = json_encode($tablahoy);
    //   echo  $json_string;

    //    $recordsFiltered = count($tablahoy);
 
    //    $recordsTotal = $recordsFiltered;

    //    header('Content-Type: application/json');
    //    echo json_encode(array(
    //     "draw" => 1,,
    //        'recordsFiltered'=> $recordsTotal,
    //        'recordsTotal'=> $recordsFiltered,
    //        'data'=> $tablahoy,
    //    ));


    

  
    
    

    // $dataset = array(
    //     "draw" => 1,
    //     "iTotalRecords" => count($tablahoy),
    //     "iTotalDisplayRecords" => count($tablahoy),
    //     "aaData" => $tablahoy
    //     );
    //     echo json_encode($dataset);
   
   
}



   


    function get_token($host,$username,$password,$payloadName) {
        $additionalHeaders = '';
        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // Execute the cURL statement
        curl_close($ch); // Close the cURL connection
        $json_token = json_decode($result, true);
        $token_received = $json_token['response']['token'];
        return($token_received);
    
    };

    function get_dataAll($host,$token,$payloadName) {
        $additionalHeaders = "Authorization: Bearer ".$token;
        $ch = curl_init();
        curl_setopt($ch,  CURLOPT_URL , $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( $additionalHeaders ));
        $result = curl_exec($ch);
        curl_close($ch);
        $json_data = json_decode($result);
        return $json_data;
    };


    function get_dataOne($host,$token,$payloadName) {
        $additionalHeaders = "Authorization: Bearer ".$token;
        $ch = curl_init();
        curl_setopt($ch,  CURLOPT_URL , $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', $additionalHeaders ));
        $result = curl_exec($ch);
        curl_close($ch);
        $json_data = json_decode($result);
        
        return $json_data;
    };
    
    
        
    
    function delete_token($host) {
    
        $additionalHeaders = '';
        $payloadName = '';
        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Specify the request method as DELETE
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // Execute the cURL statement
        curl_close($ch); // Close the cURL connection
    
        // Return the result
        return($result);
    
    };
