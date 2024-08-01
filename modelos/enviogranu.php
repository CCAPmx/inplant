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

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/granulometria/records';
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
    $Contar = $requestAll->response->dataInfo->foundCount;
    
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/granulometria/records?_offset=1&_limit=' . $Contar;
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
         for ($i = 0; $i < $Contar; $i++) {
           $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
           $zzHcreo=$requestAll->response->data[$i]->fieldData->{'zzHcreo'};
           $zzUsercreo=$requestAll->response->data[$i]->fieldData->{'zzUsercreo'};
           $zzHmodif=$requestAll->response->data[$i]->fieldData->{'zzHmodif'};
           $zzUsermodif=$requestAll->response->data[$i]->fieldData->{'zzUsermodif'};
           $maquina=$requestAll->response->data[$i]->fieldData->{'maquina'};
           $year_mes=$requestAll->response->data[$i]->fieldData->{'year_mes'};
           $tipo=$requestAll->response->data[$i]->fieldData->{'tipo'};
           $polvo=$requestAll->response->data[$i]->fieldData->{'polvo'};
           $c_05=$requestAll->response->data[$i]->fieldData->{'c_05'};
           $c_09=$requestAll->response->data[$i]->fieldData->{'c_09'};
           $c_150=$requestAll->response->data[$i]->fieldData->{'c_150'};
           $c_212=$requestAll->response->data[$i]->fieldData->{'c_212'};
           $c_300=$requestAll->response->data[$i]->fieldData->{'c_300'};
           $c_425=$requestAll->response->data[$i]->fieldData->{'c_425'};
           $c_600=$requestAll->response->data[$i]->fieldData->{'c_600'};
           $c_850=$requestAll->response->data[$i]->fieldData->{'c_850'};
           $c_1180=$requestAll->response->data[$i]->fieldData->{'c_1180'};
           $c_1400=$requestAll->response->data[$i]->fieldData->{'c_1400'};
           $c_1700=$requestAll->response->data[$i]->fieldData->{'c_1700'};
           $c_2200=$requestAll->response->data[$i]->fieldData->{'c_2200'};
           $fecha=$requestAll->response->data[$i]->fieldData->{'fecha'};
           $cobertura=$requestAll->response->data[$i]->fieldData->{'cobertura'};
           $porcentaje_600=$requestAll->response->data[$i]->fieldData->{'porcentaje_600'};
           $porcentaje_425=$requestAll->response->data[$i]->fieldData->{'porcentaje_425'};
           $porcentaje_cobertura=$requestAll->response->data[$i]->fieldData->{'porcentaje_cobertura'};

           $Sql="SELECT count(*) as contar FROM granulometria where pk='$pk' ";
           $stmt = $pdo->prepare($Sql);
           $stmt -> execute();
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           $count = $result['contar'];
        
           if($count==0){
            $stmt = $pdo->prepare('INSERT INTO granulometria (pk, zzHcreo, zzUsercreo, zzHmodif, zzUsermodif, maquina, year_mes, tipo, polvo, c_05, c_09, c_150, c_212, c_300, c_425, c_600, c_850, c_1180, c_1400, c_1700,c_2200, fecha,cobertura,porcentaje_600,porcentaje_425,porcentaje_cobertura) VALUES ( :pk, :zzHcreo, :zzUsercreo, :zzHmodif, :zzUsermodif, :maquina, :year_mes, :tipo, :polvo, :c_05, :c_09, :c_150, :c_212, :c_300, :c_425, :c_600, :c_850, :c_1180, :c_1400, :c_1700, :c_2200, :fecha, :cobertura, :porcentaje_600, :porcentaje_425, :porcentaje_cobertura)');
            $stmt->bindParam(':pk',$pk, PDO::PARAM_STR);
            $stmt->bindParam(':zzHcreo', $zzHcreo, PDO::PARAM_STR);
            $stmt->bindParam(':zzUsercreo', $zzUsercreo, PDO::PARAM_STR);
            $stmt->bindParam(':zzHmodif', $zzHmodif, PDO::PARAM_STR);
            $stmt->bindParam(':zzUsermodif', $zzUsermodif, PDO::PARAM_STR);
            $stmt->bindParam(':maquina',  $maquina, PDO::PARAM_STR);
            $stmt->bindParam(':year_mes',  $year_mes, PDO::PARAM_STR);
            $stmt->bindParam(':tipo',  $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':polvo',  $polvo, PDO::PARAM_STR);
            $stmt->bindParam(':c_05',  $c_05, PDO::PARAM_STR);
            $stmt->bindParam(':c_09',  $c_09, PDO::PARAM_STR);
            $stmt->bindParam(':c_150',  $c_150, PDO::PARAM_STR);
            $stmt->bindParam(':c_212',  $c_212, PDO::PARAM_STR);
            $stmt->bindParam(':c_300',  $c_300, PDO::PARAM_STR);
            $stmt->bindParam(':c_425',  $c_425, PDO::PARAM_STR);
            $stmt->bindParam(':c_600',  $c_600, PDO::PARAM_STR);
            $stmt->bindParam(':c_850',  $c_850, PDO::PARAM_STR);
            $stmt->bindParam(':c_1180',  $c_1180, PDO::PARAM_STR);
            $stmt->bindParam(':c_1400',  $c_1400, PDO::PARAM_STR);
            $stmt->bindParam(':c_1700',  $c_1700, PDO::PARAM_STR);
            $stmt->bindParam(':c_2200',  $c_2200, PDO::PARAM_STR);
            $stmt->bindParam(':fecha',  $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':cobertura',  $cobertura, PDO::PARAM_STR);
            $stmt->bindParam(':porcentaje_600',  $porcentaje_600, PDO::PARAM_STR);
            $stmt->bindParam(':porcentaje_425',  $porcentaje_425, PDO::PARAM_STR);
            $stmt->bindParam(':porcentaje_cobertura',  $porcentaje_cobertura, PDO::PARAM_STR);
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