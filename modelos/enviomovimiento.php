<?php

// require_once "conexion.php";
$Numeros =0;

 $host = 'localhost';
 $dbname = 'lersan';
 $username = 'root';
 $password = '';

// $host = 'localhost';
// $dbname = 'siste253_lersan';
// $username = 'siste253_root';
// $password = 'Soporte01.';


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

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Movimientos/records';
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
    $Contar = $requestAll->response->dataInfo->foundCount;
    
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Movimientos/records?_offset=1&_limit=' . $Contar;
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
         for ($i = 0; $i < $Contar; $i++) {
           $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
           $zzHcreo=$requestAll->response->data[$i]->fieldData->{'zzHcreo'};
           $zzUsercreo=$requestAll->response->data[$i]->fieldData->{'zzUsercreo'};
           $zzHmodif=$requestAll->response->data[$i]->fieldData->{'zzHmodif'};
           $zzUsermodif=$requestAll->response->data[$i]->fieldData->{'zzUsermodif'};
           $fkgranalla=$requestAll->response->data[$i]->fieldData->{'fkgranalla'};
           $tipo=$requestAll->response->data[$i]->fieldData->{'tipo'};
           $cantidad=$requestAll->response->data[$i]->fieldData->{'cantidad'};
           $usuario=$requestAll->response->data[$i]->fieldData->{'usuario'};
           $fkMaquina=$requestAll->response->data[$i]->fieldData->{'fkMaquina'};

           $Sql="SELECT count(*) as contar FROM movimientos where pk='$pk' ";
           $stmt = $pdo->prepare($Sql);
           $stmt -> execute();
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           $count = $result['contar'];
        
           if($count==0){
            $stmt = $pdo->prepare('INSERT INTO movimientos (pk, zzHcreo, zzUsercreo, zzHmodif, zzUsermodif, fkgranalla, tipo, cantidad, usuario, fkMaquina) VALUES ( :pk, :zzHcreo, :zzUsercreo, :zzHmodif, :zzUsermodif, :fkgranalla, :tipo, :cantidad, :usuario, :fkMaquina)');
            $stmt->bindParam(':pk',$pk, PDO::PARAM_STR);
            $stmt->bindParam(':zzHcreo', $zzHcreo, PDO::PARAM_STR);
            $stmt->bindParam(':zzUsercreo', $zzUsercreo, PDO::PARAM_STR);
            $stmt->bindParam(':zzHmodif', $zzHmodif, PDO::PARAM_STR);
            $stmt->bindParam(':zzUsermodif', $zzUsermodif, PDO::PARAM_STR);
            $stmt->bindParam(':fkgranalla',  $fkgranalla, PDO::PARAM_STR);
            $stmt->bindParam(':tipo',  $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':cantidad',  $cantidad, PDO::PARAM_STR);
            $stmt->bindParam(':usuario',  $usuario, PDO::PARAM_STR);
            $stmt->bindParam(':fkMaquina',  $fkMaquina, PDO::PARAM_STR);
            $stmt->execute();
            $Numeros+=1;
           }
      }

      echo ($Numeros);
      
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/sessions/'.$token;
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