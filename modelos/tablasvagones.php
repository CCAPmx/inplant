<?php
session_start();
if (isset($_POST["fk_maquina"])) {
    $token= $_SESSION["ccap"];

     $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/vagones_web_detalle/_find';
     $payloadName = '{"query": [{"fk_maquina":"'. $_POST["fk_maquina"] .'"}], "sort":[
        {"fieldName": "fecha_api", "sortOrder": "descend"}
    ]}';
     $requestAll = get_dataOne($host,$token,$payloadName); 
     $Contar = $requestAll->response->dataInfo->foundCount;
   

     
    $tablavagones = array(); //creamos un array
         for ($i = 0; $i < $Contar; $i++) {
           $alias_produccion=$requestAll->response->data[$i]->fieldData->{'alias_produccion'};
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
           $flag_regranallado=$requestAll->response->data[$i]->fieldData->{'flag_regranallado'};
           $tablavagones[] = array(
           'alias_produccion'=> $alias_produccion, 
           'fk_maquina'=> $fk_maquina,  
           'fkProducto'=> $fkProducto , 
           'flag_granallado'=> $flag_granallado, 
           'fk_proyecto'=> $fk_proyecto, 
           'serie_proyecto'=> $serie_proyecto,  
           'consecutivo_cabina'=> $consecutivo_cabina,  
           'fkCliente'=> $fkCliente,  
           'fk_cliente_lersoft'=> $fk_cliente_lersoft,  
           'nombre_cabina'=> $nombre_cabina, 
           'fecha_granallado'=> $fecha_granallado, 
           'flag_regranallado'=> $flag_regranallado);
      
      }
  

      $json_string = json_encode($tablavagones);
        echo  $json_string;
    
    
   
   
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

 ?>