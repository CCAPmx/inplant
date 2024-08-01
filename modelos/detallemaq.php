<?php
session_start();
if (isset($_POST["nombre"])) {
    $token= $_SESSION["ccap"];

     $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/maquinas_API/_find';
     $payloadName = '{"query": [{"nombre":"'. $_POST["nombre"] .'"}]}';
     $requestAll = get_dataOne($host,$token,$payloadName); 
     $Contar = $requestAll->response->dataInfo->foundCount;
   

     
    $detallemaquinas = array(); //creamos un array
         for ($i = 0; $i < $Contar; $i++) {
           $nombre=$requestAll->response->data[$i]->fieldData->{'nombre'};
           $descripcion=$requestAll->response->data[$i]->fieldData->{'descripcion'};
           $Marca_tipo_maquina=$requestAll->response->data[$i]->fieldData->{'Marca_tipo_maquina'};
           $tipo_maquina=$requestAll->response->data[$i]->fieldData->{'tipo_maquina'};
           $amp_alto=$requestAll->response->data[$i]->fieldData->{'amp_alto'};
           $amp_bajo=$requestAll->response->data[$i]->fieldData->{'amp_bajo'};
           $amperaje_vacio=$requestAll->response->data[$i]->fieldData->{'amperaje_vacio'};
           $no_turbinas_activas=$requestAll->response->data[$i]->fieldData->{'no_turbinas_activas'};
           $implant=$requestAll->response->data[$i]->fieldData->{'implant'};
           $abrasivo=$requestAll->response->data[$i]->fieldData->{'abrasivo'};
           $voltaje=$requestAll->response->data[$i]->fieldData->{'voltaje'};
           $cliente=$requestAll->response->data[$i]->fieldData->{'cliente'};
           $costo_granalla=$requestAll->response->data[$i]->fieldData->{'costo_granalla'};
           $costo_electrico=$requestAll->response->data[$i]->fieldData->{'costo_electrico'};
           $costo_personal=$requestAll->response->data[$i]->fieldData->{'costo_personal'};
           $costo_mtto_maquina=$requestAll->response->data[$i]->fieldData->{'costo_mtto_maquina'};
           $consumo_granalla_hora=$requestAll->response->data[$i]->fieldData->{'consumo_granalla_hora'};
           $perf_hora=$requestAll->response->data[$i]->fieldData->{'perf_hora'};
           $diasTipo=$requestAll->response->data[$i]->fieldData->{'diasTipo'};
           $operadores=$requestAll->response->data[$i]->fieldData->{'operadores'};
           $capacidad_silo=$requestAll->response->data[$i]->fieldData->{'capacidad_silo'};
           $tiempolectura=$requestAll->response->data[$i]->fieldData->{'tiempolectura'};
           $horometro=$requestAll->response->data[$i]->fieldData->{'horometro'};
           $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
           $fk_cliente=$requestAll->response->data[$i]->fieldData->{'fk_cliente'};
           $detallemaquinas[] = array(
            'nombre'=> $nombre, 
           'descripcion'=> $descripcion,  
           'Marca_tipo_maquina'=> $Marca_tipo_maquina , 
           'tipo_maquina'=> $tipo_maquina, 
           'amp_alto'=> $amp_alto, 
           'amp_bajo'=> $amp_bajo,  
           'amperaje_vacio'=> $amperaje_vacio,  
           'no_turbinas_activas'=> $no_turbinas_activas,  
           'implant'=> $implant,  
           'abrasivo'=> $abrasivo, 
           'voltaje'=> $voltaje, 
           'cliente'=> $cliente, 
           'costo_granalla'=> $costo_granalla, 
           'costo_electrico'=> $costo_electrico, 
           'costo_personal'=> $costo_personal, 
           'costo_mtto_maquina'=> $costo_mtto_maquina, 
           'consumo_granalla_hora'=> $consumo_granalla_hora, 
           'perf_hora'=> $perf_hora, 
           'diasTipo'=> $diasTipo, 
           'operadores'=> $operadores, 
           'capacidad_silo'=> $capacidad_silo, 
           'tiempolectura'=> $tiempolectura, 
           'horometro'=> $horometro, 
           'pk'=> $pk, 
           'fk_cliente'=> $fk_cliente);
      
      }
  

      $json_string = json_encode($detallemaquinas);
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