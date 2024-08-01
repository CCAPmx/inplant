<?php

 $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/sessions';
 $username = 'WEB_data';
 $password = 'hyx9Hxw7YkHvZTEk';
 $payloadName='';
 $token = get_token($host,$username,$password,$payloadName);

  $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/clientes_web/records';
  $payloadName = '';
  $requestAll = get_dataAll($host,$token,$payloadName); 
  $Contar = $requestAll->response->dataInfo->foundCount;
 

  $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/clientes_web/records?_offset=1&_limit=' . $Contar;
  $payloadName = '';
  $requestAll = get_dataAll($host,$token,$payloadName); 
  $clientes = array(); //creamos un array
       for ($i = 0; $i < $Contar; $i++) {
         $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
         $Codigo=$requestAll->response->data[$i]->fieldData->{'Codigo'};
         $Razon_social=$requestAll->response->data[$i]->fieldData->{'Razon_social'};
         $direccion_fiscal=$requestAll->response->data[$i]->fieldData->{'direccion_fiscal'};
         $RFC=$requestAll->response->data[$i]->fieldData->{'RFC'};
         $ID_empresa=$requestAll->response->data[$i]->fieldData->{'ID_empresa'};
         $Moneda=$requestAll->response->data[$i]->fieldData->{'Moneda'};
         $clientes[] = array('pk'=> $pk, 'Codigo'=> $Codigo, 'Razon_social'=> $Razon_social, 'direccion_fiscal'=> $direccion_fiscal,
         'RFC'=> $RFC, 'ID_empresa'=> $ID_empresa);
    
    }

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/sessions/'.$token;
    $token_deleted = delete_token($host);
    $new_array  = array("data"=>$clientes);
    echo  $json_string = json_encode($new_array);


   


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