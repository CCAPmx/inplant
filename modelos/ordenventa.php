<?php
session_start();
require_once "conexion.php";
if (isset($_POST["pk"])) {
    $ordenventa = array();
    // $rfc = $_POST["rfc"];
    // $orden = $_POST["pk"];
    // $tabladeta = "deta" . $rfc;


    // $Sql = "SELECT * from $tabladeta where fk_orden_venta='$orden'";
    // $stmt = Conexion::conectar()->prepare($Sql);
    // $stmt->execute();
    // $rows =  $stmt->fetchAll();

    // foreach ($rows as $row) {
    //     // Accede a los valores de cada fila utilizando la notación de array asociativo
     
    //     $fk_cliente_empresa= $row['fk_cliente_empresa'];
    //     $descripcion_producto=$row['descripcion_producto'];
    //     $ID_lersan= $row['ID_lersan'];
    //     $cantidad= $row['cantidad'];
    //     $PU= $row['PU'];
    //     $total= $row['total'];
    //     $fk_orden_venta=$row['fk_orden_venta'];
        
    //     $ordenventa[] = array('fk_cliente_empresa'=> $fk_cliente_empresa, 'descripcion_producto'=> $descripcion_producto, 'ID_lersan'=> $ID_lersan,  'cantidad'=> $cantidad ,'PU'=> $PU, 
    //     'total'=> $total,  'fk_orden_venta'=> $fk_orden_venta);


    // }



    // $stmt = null;



    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/sessions';
    // $username = 'WEB_data';
    // $password = 'hyx9Hxw7YkHvZTEk';
    // $payloadName='';
    // $token = get_token($host,$username,$password,$payloadName);

    $token= $_SESSION["lersant"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/orden_venta_detalle_web/_find';
     $payloadName = '{"query": [{"fk_orden_venta":"'. $_POST["pk"] .'"}]}';
     $requestAll = get_dataOne($host,$token,$payloadName); 
     $Contar = $requestAll->response->dataInfo->foundCount;
   

    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/orden_venta_detalle_web/_find';
    // $payloadName = '{"query": [{"fk_orden_venta":"'. $_POST["pk"] .'"}]}';
    // $requestAll = get_dataOne($host,$token,$payloadName); 
    $ordenventa = array(); //creamos un array
         for ($i = 0; $i < $Contar; $i++) {
           $fk_cliente_empresa=$requestAll->response->data[$i]->fieldData->{'fk_cliente_empresa'};
           $descripcion_producto=$requestAll->response->data[$i]->fieldData->{'descripcion_producto'};
           $ID_lersan=$requestAll->response->data[$i]->fieldData->{'ID_lersan'};
           $cantidad=$requestAll->response->data[$i]->fieldData->{'cantidad'};
           $PU=$requestAll->response->data[$i]->fieldData->{'PU'};
           $total=$requestAll->response->data[$i]->fieldData->{'total'};
           $fk_orden_venta=$requestAll->response->data[$i]->fieldData->{'fk_orden_venta'};
           
           $ordenventa[] = array('fk_cliente_empresa'=> $fk_cliente_empresa, 'descripcion_producto'=> $descripcion_producto, 'ID_lersan'=> $ID_lersan,  'cantidad'=> $cantidad ,'PU'=> $PU, 
           'total'=> $total,  'fk_orden_venta'=> $fk_orden_venta);
      
      }
 

    $json_string = json_encode($ordenventa);
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