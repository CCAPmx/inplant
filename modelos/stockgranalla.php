<?php
session_start();
if (isset($_POST["fkCliente"])) {
    $token= $_SESSION["ccap"];

     $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Granalla_web/_find';
     $payloadName = '{"query": [{"fkCliente":"'. $_POST["fkCliente"] .'"}]}';
     $requestAll = get_dataOne($host,$token,$payloadName); 
     $Contar = $requestAll->response->dataInfo->foundCount;
   

     
    $tablavagones = array(); //creamos un array
         for ($i = 0; $i < $Contar; $i++) {
           $codigolersoft=$requestAll->response->data[$i]->fieldData->{'codigolersoft'};
           $Descripcion=$requestAll->response->data[$i]->fieldData->{'Descripcion'};
           $entradas=$requestAll->response->data[$i]->fieldData->{'entradas'};
           $salidas=$requestAll->response->data[$i]->fieldData->{'salidas'};
           $stock=$requestAll->response->data[$i]->fieldData->{'stock'};
           $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
           $tablavagones[] = array(
           'codigolersoft'=> $codigolersoft, 
           'Descripcion'=> $Descripcion,  
           'entradas'=> $entradas , 
           'salidas'=> $salidas, 
           'stock'=> $stock,
           'pk'=> $pk);
      
      }
  

      $json_string = json_encode($tablavagones);
  

    

        // // Ruta de la carpeta donde deseas guardar el archivo JSON
         $carpeta = '../vistas/recursos/json/';

        // // Nombre del archivo JSON
         $nombreArchivo = 'stock.json';

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