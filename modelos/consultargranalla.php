<?php
session_start();
if (isset($_POST["fecha"])) {
    $tablahoy = array();
    date_default_timezone_set('America/Mexico_City');


    $servername = "65.99.225.172";
    $username = "lersanco_lersan";
    $password = "Q&h[)#[%C&{K";
    $dbname = "lersanco_lersan";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $table_name = "temcargas";
        $stmt = $conn->prepare("TRUNCATE TABLE $table_name");
        $stmt->execute();
        
       
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    $token= $_SESSION["ccap"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/RegistroCiclos_web/_find?';
    $payloadName = '{"query": [{"fecha": "'. $_POST["fecha"] .'","fkEmpresa": "'. $_POST["fk_cliente_lersoft"] .'"}]}';
    $requestAll = get_dataOne($host,$token,$payloadName); 
    $Contar = $requestAll->response->dataInfo->foundCount;
   
    $tablahoy = array();
         for ($i = 0; $i < $Contar; $i++) {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $cargas = 1;
                $cabina = $requestAll->response->data[$i]->fieldData->{'reg_cic_MAQUINAS::descripcion'};
                $granalla = $requestAll->response->data[$i]->fieldData->{'reg_cic_GRANALLA::Descripcion'};
                $cantidad = $requestAll->response->data[$i]->fieldData->{'kg'};
                $fecha = $requestAll->response->data[$i]->fieldData->{'fecha'};
                $fecha_objeto = DateTime::createFromFormat('d/m/Y', $fecha);
                $fecha_convertida = $fecha_objeto->format('Y-m-d');
            
                $sql = "INSERT INTO temcargas (cargas, cabina, granalla, cantidad, fecha) VALUES (:cargas, :cabina, :granalla, :cantidad, :fecha)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cargas', $cargas);
                $stmt->bindParam(':cabina', $cabina);
                $stmt->bindParam(':granalla', $granalla);
                $stmt->bindParam(':cantidad', $cantidad);
                $stmt->bindParam(':fecha', $fecha_convertida);
                $stmt->execute();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $conn = null;
      }


      $results = [];
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT granalla, sum(cargas) as cargas ,cabina, sum(cantidad) as cantidad   from temcargas GROUP BY	granalla order by fecha desc";
        $stmt = $conn->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
        $jsonData = json_encode($results);
        $carpeta = '../vistas/recursos/json/';
        $nombreArchivo = 'granalla.json';
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