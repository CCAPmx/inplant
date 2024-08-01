<?php
session_start();
if (isset($_POST["fkCliente"])) {
    $tablahoy = array();
    date_default_timezone_set('America/Mexico_City');

  

    $token= $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/solicitudes_web/_find?';
    $payloadName = '{"query": [{"fkCliente": "'. $_POST["fkCliente"] .'"}],
    "sort":[
        {"fieldName": "fecha", "sortOrder": "descend"}
    ]}';
    $requestAll = get_dataOne($host,$token,$payloadName); 
    $Contar = $requestAll->response->dataInfo->foundCount;
   
    $tablahoy = array();
         for ($i = 0; $i < $Contar; $i++) {
            $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
            $solicitud=$requestAll->response->data[$i]->fieldData->{'solicitud'};
            $granalla=$requestAll->response->data[$i]->fieldData->{'T14_sol_GRANALLA::Descripcion'};
            $cantidad=$requestAll->response->data[$i]->fieldData->{'cantidad'};
            $fecha=$requestAll->response->data[$i]->fieldData->{'fecha'};
            $usuario=$requestAll->response->data[$i]->fieldData->{'usuario'};
            $cliente=$requestAll->response->data[$i]->fieldData->{'T14_sol_CLIENTES::Nombre'};
            $status=$requestAll->response->data[$i]->fieldData->{'status'};
            $tablahoy[] = array(
               'pk'=> $pk, 
               'solicitud'=> $solicitud, 
               'granalla'=> $granalla,  
               'cantidad'=> $cantidad,
               'fecha'=> $fecha,
               'usuario'=> $usuario,
               'cliente'=> $cliente,
               'status'=> $status
            );
          
      }




        $jsonData = json_encode($tablahoy);
         $carpeta = '../vistas/recursos/json/';
         $nombreArchivo = 'solicitudes.json';
         $rutaCompleta = $carpeta . $nombreArchivo;
         $bytes = file_put_contents($rutaCompleta, $jsonData); 
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