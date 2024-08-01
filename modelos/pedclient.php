<?php
session_start();
require_once "conexion.php";
$tablaord = "";
$datosJson = '';
$contar = 0;
if (isset($_POST["pk"])) {
    $limit=$_POST["limit"];
    $offset=$_POST["offset"];
    // $tabla = "";
    // $rfc = $_POST["rfc"];
    // $tablaord = "orden" . $rfc;
    // $tabladeta = "deta" . $rfc;

    // try {


    //     $query = "SHOW TABLES LIKE '$tablaord'";
    //     $stmt = Conexion::conectar()->query($query);

    //     if ($stmt->rowCount() == 0) {
    //         $sql = "CREATE TABLE IF NOT EXISTS $tablaord (
    //             pk VARCHAR(50) NOT NULL,
    //             Orden VARCHAR(30) NOT NULL,
    //             Moneda VARCHAR(10),
    //             Total DECIMAL(10,2),
    //             Fecha DATE
    //         )";
    //         $stmt = Conexion::conectar()->exec($sql);
    //     } else {

    //         $sql = "TRUNCATE TABLE  $tablaord";
    //         $stmt = Conexion::conectar()->prepare($sql);
    //         $stmt->execute();
    //         $datosJson = '{"data": []}';
    //     }
    //     $stmt = null;
    // } catch (PDOException $e) {
    //     $stmt = null;
    //     $datosJson = '{"data": []}';
    // }

    // try {


    //     $query = "SHOW TABLES LIKE '$tabladeta'";
    //     $stmt = Conexion::conectar()->query($query);

    //     if ($stmt->rowCount() == 0) {
    //         $sql = "CREATE TABLE IF NOT EXISTS $tabladeta (
    //             fk_cliente_empresa VARCHAR(50) NOT NULL,
    //             descripcion_producto VARCHAR(30) NOT NULL,
    //             ID_lersan INT(11),
    //             cantidad DECIMAL(10,2),
    //             PU DECIMAL(10,2),
    //             total DECIMAL(10,2),
    //             fk_orden_venta VARCHAR(50) NOT NULL
    //         )";
    //         $stmt = Conexion::conectar()->exec($sql);
    //     } else {

    //         $sql = "TRUNCATE TABLE  $tabladeta";
    //         $stmt = Conexion::conectar()->prepare($sql);
    //         $stmt->execute();
    //         $datosJson = '{"data": []}';
    //     }
    //     $stmt = null;
    // } catch (PDOException $e) {
    //     $stmt = null;
    //     $datosJson = '{"data": []}';
    // }




    //  $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/sessions';
    //  $username = 'WEB_data';
    //  $password = 'hyx9Hxw7YkHvZTEk';
    //  $payloadName = '';
    //  $token = get_token($host, $username, $password, $payloadName);
    
     $token= $_SESSION["lersant"];

    $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/orden_venta_web_02/_find?';
    $payloadName = '{
        "query": [{"fk_empresa_cliente":"' . $_POST["pk"] . '"}],
        "limit": "' . $_POST["limit"] . '",
        "offset": "' . $_POST["offset"] . '",
        "sort":[
            {"fieldName": "zz_hcreo", "sortOrder": "descend"}
        ]
    }';

    $requestOrden = get_dataOne($host, $token, $payloadName);
    $Contarord = $requestOrden->response->dataInfo->returnedCount;


    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/orden_venta_web_02/_find';
    // $payloadName = '{"query": [{"fk_empresa_cliente":"' . $_POST["pk"] . '"}]}';
    // $requestOrden = get_dataOne($host, $token, $payloadName);
    $pedidos = array(); //creamos un array



    for ($i = 0; $i < $Contarord; $i++) {
        $Fecha = $requestOrden->response->data[$i]->fieldData->{'Fecha'};
        $Orden = $requestOrden->response->data[$i]->fieldData->{'LE'};
        $Total = $requestOrden->response->data[$i]->fieldData->{'Total'};
        $Moneda = $requestOrden->response->data[$i]->fieldData->{'Moneda'};
        $Status = $requestOrden->response->data[$i]->fieldData->{'Status OV'};
        $Transporte = $requestOrden->response->data[$i]->fieldData->{'Status Transporte'};
        $pk = $requestOrden->response->data[$i]->fieldData->{'pk'};
        
        $mifecha = new DateTime($Fecha);
        $mifecha = $mifecha->format('Y-m-d');


        $pedidos[] = array('pk'=> $pk, 'Orden'=> $Orden, 'Moneda'=> $Moneda,  'Total'=> $Total, 'Fecha'=> $mifecha, 'Status'=> $Status, 'Transporte'=> $Transporte );
        
    
      

        // if (is_null($pk)) {
        // } else {



        //     $Conex = Conexion::conectar()->prepare("INSERT INTO $tablaord  (pk, Orden, Moneda, Total, Fecha) VALUES ( :pk, :Orden, :Moneda, :Total, :Fecha)");
        //     $Conex->bindParam(':pk', $pk, PDO::PARAM_STR);
        //     $Conex->bindParam(':Orden', $Orden, PDO::PARAM_STR);
        //     $Conex->bindParam(':Moneda', $Moneda, PDO::PARAM_STR);
        //     $Conex->bindParam(':Total', $Total, PDO::PARAM_STR);
        //     $Conex->bindParam(':Fecha', $mifecha, PDO::PARAM_STR);

        //     $Conex->execute();


        //     $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/orden_venta_detalle_web/_find';
        //     $payloadName = '{"query": [{"fk_orden_venta":"' . $pk . '"}]}';
        //     $requestdetalle = get_dataOne($host, $token, $payloadName);
        //     $Contardeta = $requestdetalle->response->dataInfo->foundCount;


        //     $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/layouts/orden_venta_detalle_web/_find';
        //     $payloadName = '{"query": [{"fk_orden_venta":"' . $pk . '"}]}';
        //     $requestdetalle = get_dataOne($host, $token, $payloadName);

        //     //  $ordenventa = array(); //creamos un array
        //     for ($k = 0; $k < $Contardeta; $k++) {
        //         $fk_cliente_empresa = $requestdetalle->response->data[$k]->fieldData->{'fk_cliente_empresa'};
        //         $descripcion_producto = $requestdetalle->response->data[$k]->fieldData->{'descripcion_producto'};
        //         $ID_lersan = $requestdetalle->response->data[$k]->fieldData->{'ID_lersan'};
        //         $cantidad = $requestdetalle->response->data[$k]->fieldData->{'cantidad'};
        //         $PU = $requestdetalle->response->data[$k]->fieldData->{'PU'};
        //         $total = $requestdetalle->response->data[$k]->fieldData->{'total'};
        //         $fk_orden_venta = $requestdetalle->response->data[$k]->fieldData->{'fk_orden_venta'};


        //         $Conex = Conexion::conectar()->prepare("INSERT INTO $tabladeta  (fk_cliente_empresa, descripcion_producto, ID_lersan, cantidad, PU, total, fk_orden_venta) VALUES ( :fk_cliente_empresa, :descripcion_producto, :ID_lersan, :cantidad, :PU, :total, :fk_orden_venta)");
        //         $Conex->bindParam(':fk_cliente_empresa', $fk_cliente_empresa, PDO::PARAM_STR);
        //         $Conex->bindParam(':descripcion_producto', $descripcion_producto, PDO::PARAM_STR);
        //         $Conex->bindParam(':ID_lersan', $ID_lersan, PDO::PARAM_INT);
        //         $Conex->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
        //         $Conex->bindParam(':PU', $PU, PDO::PARAM_STR);
        //         $Conex->bindParam(':total', $total, PDO::PARAM_STR);
        //         $Conex->bindParam(':fk_orden_venta', $fk_orden_venta, PDO::PARAM_STR);

        //         $Conex->execute();
        //     }
        // }

        // $contar += 1;
    }


    // $new_array  = array("data"=>$pedidos);
  
    // $json_string = json_encode($new_array);
    // echo  $json_string;
     $json_string = json_encode($pedidos);
    echo  $json_string;

    // $host = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/sessions/' . $token;
    // $token_deleted = delete_token($host);

    // echo  $contar;
}






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

function get_dataOne($host, $token, $payloadName)
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




