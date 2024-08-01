<?php
session_start();
if (isset($_POST["pk"])) {

    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/sessions';
    // $username = 'apiccap';
    // $password = 'qwert1234';
    // $payloadName='';
    // $token = get_token($host,$username,$password,$payloadName);

    $token= $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/maquinas_API_02/_find';
     $payloadName = '{"query": [{"fk_cliente_lersoft":"'. $_POST["pk"] .'"}]}';
     $requestAll = get_dataOne($host,$token,$payloadName); 
     $Contar = $requestAll->response->dataInfo->foundCount;
   

     if (is_null($Contar)) {
        // $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/sessions/'.$token;
        // $token_deleted = delete_token($host);
        echo  "0";
    } else {
        // $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/maquinas_API_02/_find';
        // $payloadName = '{"query": [{"fk_cliente_lersoft":"'. $_POST["pk"] .'"}]}';
        // $requestAll = get_dataOne($host,$token,$payloadName); 
        $maqclient = array(); //creamos un array
             for ($i = 0; $i < $Contar; $i++) {
                $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
                $nombre=$requestAll->response->data[$i]->fieldData->{'nombre'};
                $fk_cliente_lersoft=$requestAll->response->data[$i]->fieldData->{'fk_cliente_lersoft'};
                $descripcion=$requestAll->response->data[$i]->fieldData->{'descripcion'};
            
               
             $maqclient[] = array('pk'=> $pk, 'nombre'=> $nombre, 'fk_cliente_lersoft'=> $fk_cliente_lersoft,  'descripcion'=> $descripcion );
        
            //  $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/sessions/'.$token;
            //  $token_deleted = delete_token($host);
            
          }
          $new_array  = array("data"=>$maqclient);
       
          $json_string = json_encode($new_array);
          echo  $json_string;
    }




  

    
    
   
   
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