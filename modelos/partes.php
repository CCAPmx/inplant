<?php
session_start();
if (isset($_POST["nombre"])) {
    $procesador = $_POST["nombre"];
    $pots = array("A1", "A2", "A3", "A4", "A5", "A6", "A7", "A8");
    $tipo = array("BOQUILLA", "MANGUERA", "POT");
    $error=0;
    echo "<table class='table table-striped overflow-scroll' border=2 width= 60%  align= 'center' bgcolor='#fff'>";

    echo "<thead>";
    echo "<tr>";
    echo "<th scope='col' style='display:none;'>Id</th>";
    echo "<th aria-sort='ascending' scope='col'>NOMBRE</th>";
    echo "<th scope='col'>FECHA CAMBIO</th>";
    echo "<th scope='col'>POT</th>";
    echo "<th scope='col'>USO<br>(horas)</th>";
    echo "<th scope='col'>VIDA REST<br>(horas)</th>";
    echo "<th scope='col' style='display:none;'>tipo</th>";
    echo "<th scope='col' style='display:none;'>tipomanto</th>";
    echo "<th scope='col' style='display:none;'>procesador</th>";
    echo "<th scope='col'>Editar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($tipo as $y) {
        foreach ($pots as $x) {
            $mysqli = new mysqli("68.178.221.66", "ardu", "HSNldZKxbNTDsJV", "apc_01");
            $sql = "SELECT id, nombre, fecha_cambio, pot, tipo, tipo_mantenimiento,procesador_pza, (SELECT round(SUM(" . $x . ")/3600 ,1) FROM `lecturas_a1` WHERE ID_procesador=$procesador and fecha_mex >= fecha_cambio) as USO, (vida_util_nominal-(SELECT round(SUM(" . $x . ")/3600 ,1) FROM `lecturas_a1` WHERE ID_procesador=$procesador and fecha_mex >= fecha_cambio) ) as VIDA FROM piezas_aire WHERE procesador_pza=$procesador AND pot= '" . $x . "' AND tipo= '" . $y . "'";

            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
                //se despliega el resultado  
                while ($fila = $result->fetch_assoc()) {
                    echo "<tr align='center'>";
                    echo "<td style='display:none;'>" . $fila['id'] . "</td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>" . $fila['fecha_cambio'] . "</td>";
                    echo "<td>" . $fila['pot'] . "</td>";
                    echo "<td>" . $fila['USO'] . "</td>";
                    echo "<td>" . $fila['VIDA'] . "</td>";
                    echo "<td style='display:none;'>" . $fila['tipo'] . "</td>";
                    echo "<td style='display:none;'>" . $fila['tipo_mantenimiento'] . "</td>";
                    echo "<td style='display:none;'>" . $fila['procesador_pza'] . "</td>";
                    echo "<td style='text-align:center'> <div class='text-center'><button class='btn btn-outline-info btn-sm' onclick='obtenerFecha(this)'><i class='fa-solid fa-eye'></i></button></div></td>";
                    echo "</tr>";
                }
            } else {
                $error=1;
                echo "<td colspan='7'>Sin Info</td>";
                break;
            }
        }
        if($error == 1){break;}
    }
    echo "</tbody>";
    echo "</table>";
    $mysqli->close();
}
