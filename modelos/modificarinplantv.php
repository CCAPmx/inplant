<?php
 if (isset($_POST["id"])) {
    $id = $_POST['id'];
    $fecha = $_POST['fecha'];  
    $servername = "68.178.221.66";
    $username = "ardu";
    $password = "HSNldZKxbNTDsJV";
    $dbname = "apc_01";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "UPDATE piezas_aire SET fecha_cambio='$fecha',tipo_mantenimiento='cambio'  WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
      echo 1;
    } else {
      echo 0;
    }
    
    $conn->close();
 }

?>