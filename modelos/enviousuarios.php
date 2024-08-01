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

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Usuarios/records';
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
    $Contar = $requestAll->response->dataInfo->foundCount;
    
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/Usuarios/records?_offset=1&_limit=' . $Contar;
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
         for ($i = 0; $i < $Contar; $i++) {
           $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
           $usuario=$requestAll->response->data[$i]->fieldData->{'usuario'};
           $nombre=$requestAll->response->data[$i]->fieldData->{'nombre'};
           $fkEmpresa=$requestAll->response->data[$i]->fieldData->{'fkEmpresa'};
           $activo=$requestAll->response->data[$i]->fieldData->{'activo'};
           $fkTipo=$requestAll->response->data[$i]->fieldData->{'fkTipo'};
           $produccion=$requestAll->response->data[$i]->fieldData->{'produccion'};
           $mantenimiento=$requestAll->response->data[$i]->fieldData->{'mantenimiento'};
           $bodega=$requestAll->response->data[$i]->fieldData->{'bodega'};
           $maquinas=$requestAll->response->data[$i]->fieldData->{'maquinas'};
           $password=$requestAll->response->data[$i]->fieldData->{'password'};
           $device=$requestAll->response->data[$i]->fieldData->{'device'};
           $cambiodispositivo=$requestAll->response->data[$i]->fieldData->{'cambiodispositivo'};
           $cambiopassword=$requestAll->response->data[$i]->fieldData->{'cambiopassword'};
           $TiposUsuariosnombre=$requestAll->response->data[$i]->fieldData->{'TiposUsuarios::nombre'};
           $TiposUsuariosnivel=$requestAll->response->data[$i]->fieldData->{'TiposUsuarios::nivel'};
           $token=$requestAll->response->data[$i]->fieldData->{'token'};
           $telefono=$requestAll->response->data[$i]->fieldData->{'telefono'};
           $lada=$requestAll->response->data[$i]->fieldData->{'lada'};
           $telefono_app=$requestAll->response->data[$i]->fieldData->{'telefono_app'};
           $nivel_alarmas=$requestAll->response->data[$i]->fieldData->{'nivel_alarmas'};
           if( $nivel_alarmas=""){
            $nivel_alarmas=0;
           }
           $ext_cargarGranalla=$requestAll->response->data[$i]->fieldData->{'ext_cargarGranalla'};
           $ext_cargarpiezas=$requestAll->response->data[$i]->fieldData->{'ext_cargarpiezas'};
           $ext_altapartes=$requestAll->response->data[$i]->fieldData->{'ext_altapartes'};
           $ext_vidautil=$requestAll->response->data[$i]->fieldData->{'ext_vidautil'};
           $ext_entradas=$requestAll->response->data[$i]->fieldData->{'ext_entradas'};
           $ext_salidas=$requestAll->response->data[$i]->fieldData->{'ext_salidas'};
           $fotos=$requestAll->response->data[$i]->fieldData->{'fotos'};
           $u_clientes=$requestAll->response->data[$i]->fieldData->{'u_clientes::Nombre'};
           $ext_preparacion=$requestAll->response->data[$i]->fieldData->{'ext_preparacion'};
           $ext_granallado=$requestAll->response->data[$i]->fieldData->{'ext_granallado'};
           $ext_calidad=$requestAll->response->data[$i]->fieldData->{'ext_calidad'};
           $vagones=$requestAll->response->data[$i]->fieldData->{'vagones'};

           $Sql="SELECT count(*) as contar FROM usuarios where pk='$pk' ";
           $stmt = $pdo->prepare($Sql);
           $stmt -> execute();
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           $count = $result['contar'];
        
           if($count==0){
            $stmt = $pdo->prepare('INSERT INTO usuarios (pk, usuario, nombre, fkEmpresa, activo, fkTipo, produccion, mantenimiento, bodega, maquinas, password, device, cambiodispositivo, cambiopassword, tipousuarionombre, tipousuarionivel, token, telefono, lada, telefono_app, nivel_alarmas, ext_cargarGranalla, ext_cargarpiezas, ext_altapartes, ext_vidautil, ext_entradas, ext_salidas, fotos, u_clientes, ext_preparacion, ext_granallado, ext_calidad,vagones) VALUES (:pk, :usuario, :nombre, :fkEmpresa, :activo, :fkTipo, :produccion, :mantenimiento, :bodega, :maquinas, :password, :device, :cambiodispositivo, :cambiopassword, :tipousuarionombre, :tipousuarionivel, :token, :telefono, :lada, :telefono_app, :nivel_alarmas, :ext_cargarGranalla, :ext_cargarpiezas, :ext_altapartes, :ext_vidautil, :ext_entradas, :ext_salidas, :fotos, :u_clientes, :ext_preparacion, :ext_granallado, :ext_calidad, :vagones)');
            $stmt->bindParam(':pk',$pk, PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':fkEmpresa', $fkEmpresa, PDO::PARAM_STR);
            $stmt->bindParam(':activo', $activo, PDO::PARAM_INT);
            $stmt->bindParam(':fkTipo',  $fkTipo, PDO::PARAM_STR);
            $stmt->bindParam(':produccion',  $produccion, PDO::PARAM_INT);
            $stmt->bindParam(':mantenimiento',  $mantenimiento, PDO::PARAM_INT);
            $stmt->bindParam(':bodega',  $bodega, PDO::PARAM_INT);
            $stmt->bindParam(':maquinas',  $maquinas, PDO::PARAM_INT);
            $stmt->bindParam(':password',  $password, PDO::PARAM_STR);
            $stmt->bindParam(':device',  $device, PDO::PARAM_STR);
            $stmt->bindParam(':cambiodispositivo',  $cambiodispositivo, PDO::PARAM_INT);
            $stmt->bindParam(':cambiopassword',  $cambiopassword, PDO::PARAM_INT);
            $stmt->bindParam(':tipousuarionombre',  $TiposUsuariosnombre, PDO::PARAM_STR);
            $stmt->bindParam(':tipousuarionivel',  $TiposUsuariosnivel, PDO::PARAM_INT);
            $stmt->bindParam(':token',  $token, PDO::PARAM_STR);
            $stmt->bindParam(':telefono',  $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':lada',  $lada, PDO::PARAM_STR);
            $stmt->bindParam(':telefono_app',  $telefono_app, PDO::PARAM_STR);
            $stmt->bindParam(':nivel_alarmas',  $nivel_alarmas, PDO::PARAM_INT);
            $stmt->bindParam(':ext_cargarGranalla',  $ext_cargarGranalla, PDO::PARAM_INT);
            $stmt->bindParam(':ext_cargarpiezas',  $ext_cargarpiezas, PDO::PARAM_INT);
            $stmt->bindParam(':ext_altapartes',  $ext_altapartes, PDO::PARAM_INT);
            $stmt->bindParam(':ext_vidautil',  $ext_vidautil, PDO::PARAM_INT);
            $stmt->bindParam(':ext_entradas',  $ext_entradas, PDO::PARAM_INT);
            $stmt->bindParam(':ext_salidas',  $ext_salidas, PDO::PARAM_INT);
            $stmt->bindParam(':fotos',  $fotos, PDO::PARAM_INT);
            $stmt->bindParam(':u_clientes',  $u_clientes, PDO::PARAM_STR);
            $stmt->bindParam(':ext_preparacion',  $ext_preparacion, PDO::PARAM_INT);
            $stmt->bindParam(':ext_granallado',  $ext_granallado, PDO::PARAM_INT);
            $stmt->bindParam(':ext_calidad',  $ext_calidad, PDO::PARAM_INT);
            $stmt->bindParam(':vagones',  $vagones, PDO::PARAM_INT);
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