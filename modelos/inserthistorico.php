<?php
 if (isset($_POST["id_parte"])) {
  $servername = "68.178.221.66";
  $username = "ardu";
  $password = "HSNldZKxbNTDsJV";
  $dbname = "apc_01";

 
  $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
  $pot = (isset($_POST['pot'])) ? $_POST['pot'] : '';
  $procesador_pza = (isset($_POST['procesador_pza'])) ? $_POST['procesador_pza'] : 0;
  $fecha_ini = (isset($_POST['fecha_ini'])) ? $_POST['fecha_ini'] : '';
  $fecha_fin = (isset($_POST['fecha_fin'])) ? $_POST['fecha_fin'] : '';
  $tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
  $tipo_mantenimiento = (isset($_POST['tipo_mantenimiento'])) ? $_POST['tipo_mantenimiento'] : '';
  $id_parte = (isset($_POST['id_parte'])) ? $_POST['id_parte'] : 0;
  $operacion = (isset($_POST['operacion'])) ? $_POST['operacion'] : '';
  $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
  $horas=0;
   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
   if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
   }

$consulta="SELECT round(SUM(A2)/3600 ,1) as horas FROM lecturas_a1 WHERE ID_procesador=$procesador_pza and fecha_mex BETWEEN (SELECT fecha_cambio FROM piezas_aire WHERE id=$id_parte) AND TIMESTAMP('$fecha_fin')";
if ($resultado = $conn->query($consulta)) {
  while ( $fila = $resultado->fetch_assoc() ) {
    $horas= $fila["horas"];
  }
}else{
  $horas= 0;
}
 
    
     $sql = "INSERT INTO piezas_aire_hist (nombre,pot,procesador_pza,fecha_ini,fecha_fin,tipo,tipo_mantenimiento,horas,id_parte,usuario) VALUES('$nombre','$pot',$procesador_pza,'$fecha_ini','$fecha_fin','$tipo','$operacion', '$horas',$id_parte, '$usuario')";
    
     if ($conn->query($sql) === TRUE) {
       echo 1;
     } else {
       echo 0;
     }
    
    $conn->close();
 }

?>