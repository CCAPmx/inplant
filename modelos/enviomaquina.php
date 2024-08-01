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

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/maquinas_API/records';
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
    $Contar = $requestAll->response->dataInfo->foundCount;
    
    $host = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/layouts/maquinas_API/records?_offset=1&_limit=' . $Contar;
    $payloadName = '';
    $requestAll = get_dataAll($host,$token,$payloadName); 
         for ($i = 0; $i < $Contar; $i++) {
           $pk=$requestAll->response->data[$i]->fieldData->{'pk'};
           $nombre=$requestAll->response->data[$i]->fieldData->{'nombre'};
           $voltaje=$requestAll->response->data[$i]->fieldData->{'voltaje'};
           $amperaje_vacio=$requestAll->response->data[$i]->fieldData->{'amperaje_vacio'};
           $Marca_tipo_maquina=$requestAll->response->data[$i]->fieldData->{'Marca_tipo_maquina'};
           $cantidad_turbinas=$requestAll->response->data[$i]->fieldData->{'cantidad_turbinas'};
           $amperaje_max=$requestAll->response->data[$i]->fieldData->{'amperaje_max'};
           $amp_bajo=$requestAll->response->data[$i]->fieldData->{'amp_bajo'};
           $amp_alto=$requestAll->response->data[$i]->fieldData->{'amp_alto'};
           $HP=$requestAll->response->data[$i]->fieldData->{'HP'};
           $codigo_lersoft_granalla=$requestAll->response->data[$i]->fieldData->{'codigo_lersoft_granalla'};
           $T01_maq_GRANALLA=$requestAll->response->data[$i]->fieldData->{'T01_maq_GRANALLA::codigolersoft'};
           $fk_cliente=$requestAll->response->data[$i]->fieldData->{'fk_cliente'};
           $costo_granalla=$requestAll->response->data[$i]->fieldData->{'costo_granalla'};
           $costo_electrico=$requestAll->response->data[$i]->fieldData->{'costo_electrico'};
           $costo_personal=$requestAll->response->data[$i]->fieldData->{'costo_personal'};
           $costo_mtto_maquina=$requestAll->response->data[$i]->fieldData->{'costo_mtto_maquina'};
           $producto=$requestAll->response->data[$i]->fieldData->{'producto'};
           $abrasivo=$requestAll->response->data[$i]->fieldData->{'abrasivo'};
           $consumo_granalla_hora=$requestAll->response->data[$i]->fieldData->{'consumo_granalla_hora'};
           $ciclos_dia_esperado=$requestAll->response->data[$i]->fieldData->{'ciclos_dia_esperado'};
           $piezas_x_ciclo=$requestAll->response->data[$i]->fieldData->{'piezas_x_ciclo'};
           $zz_constant=$requestAll->response->data[$i]->fieldData->{'zz_constant'};
           $descripcion=$requestAll->response->data[$i]->fieldData->{'descripcion'};
           $tipo_maquina=$requestAll->response->data[$i]->fieldData->{'tipo_maquina'};
           $no_turbinas_activas=$requestAll->response->data[$i]->fieldData->{'no_turbinas_activas'};
           $usuario=$requestAll->response->data[$i]->fieldData->{'usuario'};
           $metroslineales=$requestAll->response->data[$i]->fieldData->{'metroslineales'};
           $granalla_restante=$requestAll->response->data[$i]->fieldData->{'granalla_restante'};
           $nivel1=$requestAll->response->data[$i]->fieldData->{'nivel1'};
           $nivel2=$requestAll->response->data[$i]->fieldData->{'nivel2'};
           $nivel3=$requestAll->response->data[$i]->fieldData->{'nivel3'};
           $nivel4=$requestAll->response->data[$i]->fieldData->{'nivel4'};
           $perf_hora=$requestAll->response->data[$i]->fieldData->{'perf_hora'};
           $max_escala=$requestAll->response->data[$i]->fieldData->{'max_escala'};
           $min_escala=$requestAll->response->data[$i]->fieldData->{'min_escala'};
           $min_amperaje=$requestAll->response->data[$i]->fieldData->{'min_amperaje'};
           $max_amperaje=$requestAll->response->data[$i]->fieldData->{'max_amperaje'};
           $factor_escala=$requestAll->response->data[$i]->fieldData->{'factor_escala'};
           $activa=$requestAll->response->data[$i]->fieldData->{'activa'};
           $operadores=$requestAll->response->data[$i]->fieldData->{'operadores'};
           $potencia=$requestAll->response->data[$i]->fieldData->{'potencia'};
           $capacidad_silo=$requestAll->response->data[$i]->fieldData->{'capacidad_silo'};
           $nivel1_amperaje=$requestAll->response->data[$i]->fieldData->{'nivel1_amperaje'};
           $nivel2_amperaje=$requestAll->response->data[$i]->fieldData->{'nivel2_amperaje'};
           $nivel3_amperaje=$requestAll->response->data[$i]->fieldData->{'nivel3_amperaje'};
           $nivel4_amperaje=$requestAll->response->data[$i]->fieldData->{'nivel4_amperaje'};
           $flag_reporte=$requestAll->response->data[$i]->fieldData->{'flag_reporte'};
           $diasTipo=$requestAll->response->data[$i]->fieldData->{'diasTipo'};
           $cliente=$requestAll->response->data[$i]->fieldData->{'cliente'};
           $amp_critico=$requestAll->response->data[$i]->fieldData->{'amp_critico'};
           $ultima_lectura=$requestAll->response->data[$i]->fieldData->{'ultima_lectura'};
           $horas=$requestAll->response->data[$i]->fieldData->{'horas'};
           $concat=$requestAll->response->data[$i]->fieldData->{'concat'};
           $psi_min=$requestAll->response->data[$i]->fieldData->{'psi_min'};
           $psi_max=$requestAll->response->data[$i]->fieldData->{'psi_max'};
           $produccion=$requestAll->response->data[$i]->fieldData->{'produccion'};
           $implant=$requestAll->response->data[$i]->fieldData->{'implant'};
           $nuevo=$requestAll->response->data[$i]->fieldData->{'nuevo'};
           $tiempolectura=$requestAll->response->data[$i]->fieldData->{'tiempolectura'};
           $mangueras_sopleteo=$requestAll->response->data[$i]->fieldData->{'mangueras_sopleteo'};
           $tiempo_vagon=$requestAll->response->data[$i]->fieldData->{'tiempo_vagon'};
           $horometro=$requestAll->response->data[$i]->fieldData->{'horometro'};
           $constante_silo=$requestAll->response->data[$i]->fieldData->{'constante_silo'};
           $granalla_zona_muerta=$requestAll->response->data[$i]->fieldData->{'granalla_zona_muerta'};
           $granalla_pots=$requestAll->response->data[$i]->fieldData->{'granalla_pots'};
           $altura_silo=$requestAll->response->data[$i]->fieldData->{'altura_silo'};

           $Sql="SELECT count(*) as contar FROM maquinas_api where pk='$pk' ";
           $stmt = $pdo->prepare($Sql);
           $stmt -> execute();
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           $count = $result['contar'];
        
           if($count==0){
            $stmt = $pdo->prepare('INSERT INTO maquinas_api (pk, nombre, voltaje, amperaje_vacio, Marca_tipo_maquina, cantidad_turbinas, amperaje_max, amp_bajo, amp_alto, HP, codigo_lersoft_granalla, T01_maq_GRANALLA, fk_cliente, costo_granalla, costo_electrico, costo_personal, costo_mtto_maquina, producto, abrasivo, consumo_granalla_hora,ciclos_dia_esperado, piezas_x_ciclo,zz_constant,descripcion,tipo_maquina,no_turbinas_activas, 
            usuario, metroslineales, granalla_restante, nivel1, nivel2, nivel3, nivel4, perf_hora, max_escala, min_escala, min_amperaje, max_amperaje, factor_escala, activa, operadores, potencia, capacidad_silo, nivel1_amperaje, nivel2_amperaje, nivel3_amperaje,nivel4_amperaje, flag_reporte,diasTipo,cliente,amp_critico,ultima_lectura,
            horas, concat, psi_min, psi_max, produccion, implant, nuevo, tiempolectura, mangueras_sopleteo, tiempo_vagon, horometro, constante_silo, granalla_zona_muerta, granalla_pots,altura_silo) 
            VALUES ( :pk, :nombre, :voltaje, :amperaje_vacio, :Marca_tipo_maquina, :cantidad_turbinas, :amperaje_max, :amp_bajo, :amp_alto, :HP, :codigo_lersoft_granalla, :T01_maq_GRANALLA, :fk_cliente, :costo_granalla, :costo_electrico, :costo_personal, :costo_mtto_maquina, :producto, :abrasivo, :consumo_granalla_hora, :ciclos_dia_esperado, :piezas_x_ciclo, :zz_constant, :descripcion, :tipo_maquina, :no_turbinas_activas, 
            :usuario, :metroslineales, :granalla_restante, :nivel1, :nivel2, :nivel3, :nivel4, :perf_hora, :max_escala, :min_escala, :min_amperaje, :max_amperaje, :factor_escala, :activa, :operadores, :potencia, :capacidad_silo, :nivel1_amperaje, :nivel2_amperaje, :nivel3_amperaje, :nivel4_amperaje, :flag_reporte, :diasTipo, :cliente, :amp_critico, :ultima_lectura, 
            :horas, :concat, :psi_min, :psi_max, :produccion, :implant, :nuevo, :tiempolectura, :mangueras_sopleteo, :tiempo_vagon, :horometro, :constante_silo, :granalla_zona_muerta, :granalla_pots, :altura_silo)');
            $stmt->bindParam(':pk',$pk, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':voltaje', $voltaje, PDO::PARAM_STR);
            $stmt->bindParam(':amperaje_vacio', $amperaje_vacio, PDO::PARAM_STR);
            $stmt->bindParam(':Marca_tipo_maquina', $Marca_tipo_maquina, PDO::PARAM_STR);
            $stmt->bindParam(':cantidad_turbinas',  $cantidad_turbinas, PDO::PARAM_STR);
            $stmt->bindParam(':amperaje_max',  $amperaje_max, PDO::PARAM_STR);
            $stmt->bindParam(':amp_bajo',  $amp_bajo, PDO::PARAM_STR);
            $stmt->bindParam(':amp_alto',  $amp_alto, PDO::PARAM_STR);
            $stmt->bindParam(':HP',  $HP, PDO::PARAM_STR);
            $stmt->bindParam(':codigo_lersoft_granalla',  $codigo_lersoft_granalla, PDO::PARAM_STR);
            $stmt->bindParam(':T01_maq_GRANALLA',  $T01_maq_GRANALLA, PDO::PARAM_STR);
            $stmt->bindParam(':fk_cliente',  $fk_cliente, PDO::PARAM_STR);
            $stmt->bindParam(':costo_granalla',  $costo_granalla, PDO::PARAM_STR);
            $stmt->bindParam(':costo_electrico',  $costo_electrico, PDO::PARAM_STR);
            $stmt->bindParam(':costo_personal',  $costo_personal, PDO::PARAM_STR);
            $stmt->bindParam(':costo_mtto_maquina',  $costo_mtto_maquina, PDO::PARAM_STR);
            $stmt->bindParam(':producto',  $producto, PDO::PARAM_STR);
            $stmt->bindParam(':abrasivo',  $abrasivo, PDO::PARAM_STR);
            $stmt->bindParam(':consumo_granalla_hora',  $consumo_granalla_hora, PDO::PARAM_STR);
            $stmt->bindParam(':ciclos_dia_esperado',  $ciclos_dia_esperado, PDO::PARAM_STR);
            $stmt->bindParam(':piezas_x_ciclo',  $piezas_x_ciclo, PDO::PARAM_STR);
            $stmt->bindParam(':zz_constant',  $zz_constant, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion',  $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_maquina',  $tipo_maquina, PDO::PARAM_STR);
            $stmt->bindParam(':no_turbinas_activas',  $no_turbinas_activas, PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->bindParam(':metroslineales', $metroslineales, PDO::PARAM_STR);
            $stmt->bindParam(':granalla_restante', $granalla_restante, PDO::PARAM_STR);
            $stmt->bindParam(':nivel1', $nivel1, PDO::PARAM_STR);
            $stmt->bindParam(':nivel2',  $nivel2, PDO::PARAM_STR);
            $stmt->bindParam(':nivel3',  $nivel3, PDO::PARAM_STR);
            $stmt->bindParam(':nivel4',  $nivel4, PDO::PARAM_STR);
            $stmt->bindParam(':perf_hora',  $perf_hora, PDO::PARAM_STR);
            $stmt->bindParam(':max_escala',  $max_escala, PDO::PARAM_STR);
            $stmt->bindParam(':min_escala',  $min_escala, PDO::PARAM_STR);
            $stmt->bindParam(':min_amperaje',  $min_amperaje, PDO::PARAM_STR);
            $stmt->bindParam(':max_amperaje',  $max_amperaje, PDO::PARAM_STR);
            $stmt->bindParam(':factor_escala',  $factor_escala, PDO::PARAM_STR);
            $stmt->bindParam(':activa',  $activa, PDO::PARAM_STR);
            $stmt->bindParam(':operadores',  $operadores, PDO::PARAM_STR);
            $stmt->bindParam(':potencia',  $potencia, PDO::PARAM_STR);
            $stmt->bindParam(':capacidad_silo',  $capacidad_silo, PDO::PARAM_STR);
            $stmt->bindParam(':nivel1_amperaje',  $nivel1_amperaje, PDO::PARAM_STR);
            $stmt->bindParam(':nivel2_amperaje',  $nivel2_amperaje, PDO::PARAM_STR);
            $stmt->bindParam(':nivel3_amperaje',  $nivel3_amperaje, PDO::PARAM_STR);
            $stmt->bindParam(':nivel4_amperaje',  $nivel4_amperaje, PDO::PARAM_STR);
            $stmt->bindParam(':flag_reporte',  $flag_reporte, PDO::PARAM_STR);
            $stmt->bindParam(':diasTipo',  $diasTipo, PDO::PARAM_STR);
            $stmt->bindParam(':cliente',  $cliente, PDO::PARAM_STR);
            $stmt->bindParam(':amp_critico',  $amp_critico, PDO::PARAM_STR);
            $stmt->bindParam(':ultima_lectura', $ultima_lectura, PDO::PARAM_STR);
            $stmt->bindParam(':horas', $horas, PDO::PARAM_STR);
            $stmt->bindParam(':concat', $concat, PDO::PARAM_STR);
            $stmt->bindParam(':psi_min', $psi_min, PDO::PARAM_STR);
            $stmt->bindParam(':psi_max',  $psi_max, PDO::PARAM_STR);
            $stmt->bindParam(':produccion',  $produccion, PDO::PARAM_STR);
            $stmt->bindParam(':implant',  $implant, PDO::PARAM_STR);
            $stmt->bindParam(':nuevo',  $nuevo, PDO::PARAM_STR);
            $stmt->bindParam(':tiempolectura',  $tiempolectura, PDO::PARAM_STR);
            $stmt->bindParam(':mangueras_sopleteo',  $mangueras_sopleteo, PDO::PARAM_STR);
            $stmt->bindParam(':tiempo_vagon',  $tiempo_vagon, PDO::PARAM_STR);
            $stmt->bindParam(':horometro',  $horometro, PDO::PARAM_STR);
            $stmt->bindParam(':constante_silo',  $constante_silo, PDO::PARAM_STR);
            $stmt->bindParam(':granalla_zona_muerta',  $granalla_zona_muerta, PDO::PARAM_STR);
            $stmt->bindParam(':granalla_pots',  $granalla_pots, PDO::PARAM_STR);
            $stmt->bindParam(':altura_silo',  $altura_silo, PDO::PARAM_STR);
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