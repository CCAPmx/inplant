<?php

// require_once "conexion.php";
$Numeros = 0;


// $host = 'localhost';
// $dbname = 'lersanco_lersan';
// $username = 'root';
// $password = '';

 $host = 'localhost';
 $dbname = 'lersanco_lersan';
 $username = 'lersanco_lersan';
 $password = 'Q&h[)#[%C&{K';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}



try {


    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/sessions';
    // $username = 'apiccap';
    // $password = 'qwert1234';
    $payloadName = '';

    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/sessions';
    $host = 'https://fms.lersan.com/fmi/data/v2/databases/CCAP/sessions';
    $username = 'WEB_data';
    $password = 'hyx9Hxw7YkHvZTEk';
    // $payloadName='';
    $token = get_token($host, $username, $password, $payloadName);

    // var_dump($token);

    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/clientes_web/records';
    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/clientes_web/records'; 
    $host = 'https://fms.lersan.com/fmi/data/v2/databases/CCAP/layouts/clientes_web/_find?';


    $payloadName = '{
        "query": [
          {
            "inplant_activo": "1"
          }
        ]
      }';

    $requestAll = get_post($host, $token, $payloadName);


    $Contar = $requestAll->response->dataInfo->foundCount;
    // header('Content-Type: application/json');
    // var_dump($requestAll->response->data[0]->fieldData->{'pk'});
    // var_dump($Contar);

    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/clientes_web/records?_offset=1&_limit=' . $Contar;
    // $payloadName = '';
    // $requestAll = get_dataAll($host, $token, $payloadName);

    // var_dump($requestAll);

    $sql = "TRUNCATE TABLE `tbclientes`";
    //Prepare la consulta SQL.
    $statement = $pdo->prepare($sql);

    //Ejecute la instrucción.
    $statement->execute();

         for ($i = 0; $i < $Contar; $i++) {
        //    $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
        //    $codigo=$requestAll->response->data[$i]->fieldData->{'Codigo'};
        //    $Razon_social=$requestAll->response->data[$i]->fieldData->{'Razon_social'};
        //    $direccion_fiscal=$requestAll->response->data[$i]->fieldData->{'direccion_fiscal'};
        //    $RFC=$requestAll->response->data[$i]->fieldData->{'RFC'};
        //    $ID_empresa=$requestAll->response->data[$i]->fieldData->{'ID_empresa'};

           $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
           $Nombre=$requestAll->response->data[$i]->fieldData->{'Nombre'};
           $nombrecorto=$requestAll->response->data[$i]->fieldData->{'nombrecorto'};
           $RFC=$requestAll->response->data[$i]->fieldData->{'RFC'};
           $inplant_activo=$requestAll->response->data[$i]->fieldData->{'inplant_activo'};
        //    $Moneda=$requestAll->response->data[$i]->fieldData->{'Moneda'};

        if ($RFC!=""){

            $Sql="SELECT count(*) as contar FROM tbclientes where pk='$pk' ";
            $stmt = $pdo->prepare($Sql);
            $stmt -> execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $result['contar'];

            if($count==0){


                $stmt = $pdo->prepare('INSERT INTO 
                tbclientes (pk,Razon_social, RFC, nombre_corto,activo) 
                VALUES 
                ( :pk, :Razon_social, :RFC, :nombre_corto,:activo)');
                $stmt->bindParam(':pk',$pk, PDO::PARAM_STR);             
                $stmt->bindParam(':Razon_social', $Nombre, PDO::PARAM_STR);            
                $stmt->bindParam(':RFC', $RFC, PDO::PARAM_STR);
                $stmt->bindParam(':nombre_corto', $nombrecorto, PDO::PARAM_STR);
                $stmt->bindParam(':activo', $inplant_activo, PDO::PARAM_STR);


            //  $stmt = $pdo->prepare('INSERT INTO tbclientes (pk, Codigo, Razon_social, direccion_fiscal, RFC, ID_empresa) VALUES ( :pk, :Codigo, :Razon_social, :direccion_fiscal, :RFC, :ID_empresa)');
            //  $stmt->bindParam(':pk',$pk, PDO::PARAM_STR);
            //  $stmt->bindParam(':Codigo', $codigo, PDO::PARAM_INT);
            //  $stmt->bindParam(':Razon_social', $Razon_social, PDO::PARAM_STR);
            //  $stmt->bindParam(':direccion_fiscal', $direccion_fiscal, PDO::PARAM_STR);
            //  $stmt->bindParam(':RFC', $RFC, PDO::PARAM_STR);
            //  $stmt->bindParam(':ID_empresa',  $ID_empresa, PDO::PARAM_INT);

             $stmt->execute();
             $Numeros+=1;
            }


        }





      }



    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/sessions' . $token;
    $token_deleted = delete_token($host);
    echo ($Numeros);
} catch (PDOException $e) {
    die("Error executing the query: " . $e->getMessage());
}

$stmt = null;
$pdo = null;

function get_token($host, $username, $password, $payloadName)
{
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
    return ($token_received);
};

function get_dataAll($host, $token, $payloadName)
{
    $additionalHeaders = "Authorization: Bearer " . $token;
    $ch = curl_init();
    curl_setopt($ch,  CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($additionalHeaders));
    $result = curl_exec($ch);
    curl_close($ch);
    $json_data = json_decode($result);
    return $json_data;
};



function get_post($host, $token, $payloadName)
{
    $additionalHeaders = "Authorization: Bearer " . $token;
    $ch = curl_init();
    curl_setopt($ch,  CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
    $result = curl_exec($ch);
    curl_close($ch);
    $json_data = json_decode($result);

    return $json_data;
};

function delete_token($host)
{

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
    return ($result);
};
