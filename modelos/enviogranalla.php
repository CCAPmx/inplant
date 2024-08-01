<?php

// require_once "conexion.php";
$Numeros =0;

// $host = 'localhost';
// $dbname = 'lersan';
// $username = 'root';
// $password = '';

$host = 'localhost';
$dbname = 'siste253_lersan';
$username = 'siste253_root';
$password = 'Soporte01.';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}



try {
    
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/sessions';
    $username = 'apiccap';
    $password = 'qwert1234';
    $payloadName='';
    $token = get_token($host,$username,$password,$payloadName);

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Granalla/records';
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
    $Contar = $requestAll->response->dataInfo->foundCount;
    
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Granalla/records?_offset=1&_limit=' . $Contar;
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
         for ($i = 0; $i < $Contar; $i++) {
           $idTipoProducto=$requestAll->response->data[$i]->fieldData->{'idTipoProducto'};
           $Descripcion=$requestAll->response->data[$i]->fieldData->{'Descripcion'};
           $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
           $codigolersoft=$requestAll->response->data[$i]->fieldData->{'codigolersoft'};
           $fkCliente=$requestAll->response->data[$i]->fieldData->{'fkCliente'};
           $entradas=$requestAll->response->data[$i]->fieldData->{'entradas'};
           $salidas=$requestAll->response->data[$i]->fieldData->{'salidas'};
           $stock=$requestAll->response->data[$i]->fieldData->{'stock'};
           $constante_entrada=$requestAll->response->data[$i]->fieldData->{'constante_entrada'};
           $constante_salida=$requestAll->response->data[$i]->fieldData->{'constante_salida'};
           $nivel_critico=$requestAll->response->data[$i]->fieldData->{'nivel_critico'};
           $demora=$requestAll->response->data[$i]->fieldData->{'demora'};
           $gr_clientes=$requestAll->response->data[$i]->fieldData->{'gr_clientes::Nombre'};

           $Sql="SELECT count(*) as contar FROM granalla where pk='$pk' ";
           $stmt = $pdo->prepare($Sql);
           $stmt -> execute();
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           $count = $result['contar'];
        
           if($count==0){
            $stmt = $pdo->prepare('INSERT INTO granalla (idTipoProducto, Descripcion, pk, codigolersoft, fkCliente, entradas, salidas, stock, constante_entrada, constante_salida,nivel_critico,demora,gr_clientes) VALUES ( :idTipoProducto, :Descripcion, :pk, :codigolersoft, :fkCliente, :entradas, :salidas, :stock, :constante_entrada, :constante_salida, :nivel_critico, :demora, :gr_clientes)');
            $stmt->bindParam(':idTipoProducto',$idTipoProducto, PDO::PARAM_STR);
            $stmt->bindParam(':Descripcion', $Descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':pk', $pk, PDO::PARAM_STR);
            $stmt->bindParam(':codigolersoft', $codigolersoft, PDO::PARAM_STR);
            $stmt->bindParam(':fkCliente', $fkCliente, PDO::PARAM_STR);
            $stmt->bindParam(':entradas',  $entradas, PDO::PARAM_STR);
            $stmt->bindParam(':salidas',  $salidas, PDO::PARAM_STR);
            $stmt->bindParam(':stock',  $stock, PDO::PARAM_STR);
            $stmt->bindParam(':constante_entrada',  $constante_entrada, PDO::PARAM_STR);
            $stmt->bindParam(':constante_salida',  $constante_salida, PDO::PARAM_STR);
            $stmt->bindParam(':nivel_critico',  $nivel_critico, PDO::PARAM_STR);
            $stmt->bindParam(':demora',  $demora, PDO::PARAM_STR);
            $stmt->bindParam(':gr_clientes',  $gr_clientes, PDO::PARAM_STR);
            $stmt->execute();
            $Numeros+=1;
           }
      }

      echo ($Numeros);
      
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/sessions/'.$token;
    $token_deleted = delete_token($host);
    // var_dump($token_deleted );
   

} catch (PDOException $e) {
    die("Error executing the query: " . $e->getMessage());
}

$stmt=null;
$pdo = null;

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