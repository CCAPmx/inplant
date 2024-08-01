<?php
session_start();
require_once "conexion.php";
if (isset($_POST["ID_procesador"])) {
    $tablahoy = array();
    date_default_timezone_set('America/Mexico_City');

    // $fechaActual = date("m-d-Y");
    $fechaActual = str_replace("-", "/", $_POST["fecha"]);

    $token= $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/aux_reporte_presion/_find?';
     $payloadName = '{"query": [{"ID_procesador":"'. $_POST["ID_procesador"] .'","fecha": "'. $fechaActual .'"}],"limit":"'. $_POST["contador"] .'"}';
     $requestAll = get_dataOne($host,$token,$payloadName); 
     $Contar = $requestAll->response->dataInfo->foundCount;
   
    $tablahoy = array(); //creamos un array
         for ($i = 0; $i < $Contar; $i++) {
           $Fecha_mex=$requestAll->response->data[$i]->fieldData->{'Fecha_mex'};
           $presion=$requestAll->response->data[$i]->fieldData->{'presion'};
           $nivel=$requestAll->response->data[$i]->fieldData->{'nivel'};
           $tendencia=$requestAll->response->data[$i]->fieldData->{'tendencia'};
           $a1=$requestAll->response->data[$i]->fieldData->{'a1'};
           $a2=$requestAll->response->data[$i]->fieldData->{'a2'};
           $a3=$requestAll->response->data[$i]->fieldData->{'a3'};
           $a4=$requestAll->response->data[$i]->fieldData->{'a4'};
           $a5=$requestAll->response->data[$i]->fieldData->{'a5'};
           $a6=$requestAll->response->data[$i]->fieldData->{'a6'};
           $a7=$requestAll->response->data[$i]->fieldData->{'a7'};
           $a8=$requestAll->response->data[$i]->fieldData->{'a8'};
           $a9=$requestAll->response->data[$i]->fieldData->{'a9'};
           $a10=$requestAll->response->data[$i]->fieldData->{'a10'};
           $a11=$requestAll->response->data[$i]->fieldData->{'a11'};
           $a12=$requestAll->response->data[$i]->fieldData->{'a12'};
           $fecha=$requestAll->response->data[$i]->fieldData->{'fecha'};
           $ID_procesador=$requestAll->response->data[$i]->fieldData->{'ID_procesador'};
           $t=$requestAll->response->data[$i]->fieldData->{'t'};
           $t1=$requestAll->response->data[$i]->fieldData->{'t1'};
           $ty=$requestAll->response->data[$i]->fieldData->{'ty'};
           $t2=$requestAll->response->data[$i]->fieldData->{'t2'};
           $label=$requestAll->response->data[$i]->fieldData->{'label'};
           $t_a1=$requestAll->response->data[$i]->fieldData->{'t_a1'};
           $t_a2=$requestAll->response->data[$i]->fieldData->{'t_a2'};
           $t_a3=$requestAll->response->data[$i]->fieldData->{'t_a3'};
           $t_a4=$requestAll->response->data[$i]->fieldData->{'t_a4'};
           $t_a5=$requestAll->response->data[$i]->fieldData->{'t_a5'};
           $t_a6=$requestAll->response->data[$i]->fieldData->{'t_a6'};
           $t_a7=$requestAll->response->data[$i]->fieldData->{'t_a7'};
           $t_a8=$requestAll->response->data[$i]->fieldData->{'t_a8'};
           $t_a9=$requestAll->response->data[$i]->fieldData->{'t_a9'};
           $t_a10=$requestAll->response->data[$i]->fieldData->{'t_a10'};
           $t_a11=$requestAll->response->data[$i]->fieldData->{'t_a11'};
           $t_a12=$requestAll->response->data[$i]->fieldData->{'t_a12'};
           $sum_t=$requestAll->response->data[$i]->fieldData->{'sum_t'};
           $Turno=$requestAll->response->data[$i]->fieldData->{'Turno'};
           $max_tiempo=$requestAll->response->data[$i]->fieldData->{'max_tiempo'};

           
           $tablahoy[] = array('Fecha_mex'=> $Fecha_mex, 'presion'=> $presion, 'nivel'=> $nivel,  'tendencia'=> $tendencia ,'a1'=> $a1, 
           'a2'=> $a2, 'a3'=> $a3, 'a4'=> $a4, 'a5'=> $a5, 'a6'=> $a6, 'a7'=> $a7, 'a8'=> $a8, 'a9'=> $a9, 'a10'=> $a10, 'a11'=> $a11, 'a12'=> $a12,
           'fecha'=> $fecha, 'ID_procesador'=> $ID_procesador, 't'=> $t, 't1'=> $t1, 'ty'=> $ty, 't2'=> $t2, 'label'=> $label, 't_a1'=> $t_a1, 't_a2'=> $t_a2, 't_a3'=> $t_a3,
           't_a4'=> $t_a4, 't_a5'=> $t_a5, 't_a6'=> $t_a6, 't_a7'=> $t_a7, 't_a8'=> $t_a8, 't_a9'=> $t_a9, 't_a10'=> $t_a10, 't_a11'=> $t_a11, 't_a12'=> $t_a12, 'sum_t'=> $sum_t, 
           'Turno'=> $Turno, 'max_tiempo'=> $max_tiempo);
      
      }
 

    $json_string = json_encode($tablahoy);
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