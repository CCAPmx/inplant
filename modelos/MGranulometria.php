<?php
// session_start();

require_once "conexion.php";
class mainGranulometria
{


    public function dataGranulometriaGreenbrierSelector()
    {


        $objConexion = new conexion();
        $sql = "SELECT 
    g.*, 
    m.*,
    m.cliente, 
    CASE 
        WHEN re.id_granulometria IS NOT NULL THEN 1 
        ELSE 0 
    END AS usada
FROM granulometria AS g
INNER JOIN maquinas AS m ON g.procesador = m.procesador_maq
LEFT JOIN reporte_especial AS re ON g.id = re.id_granulometria
WHERE m.cliente = 'GREENBRIER'
ORDER BY g.fecha_server DESC;";

        $stmt = $objConexion->conectarDooble()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return [
                'success' => false,
                'message' => 'No hay registros',
                'status' => 400
            ];
        }

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ✅ Agregar URL de imagen dinámica
        foreach ($datos as &$row) {
            $id = $row['id']; // Asegúrate de tener 'id' en la tabla
            $row['imagen_url_1'] = "ver_imagen_granulometria.php?id=$id&campo=basura_img01";
            $row['imagen_url_2'] = "ver_imagen_granulometria.php?id=$id&campo=basura_img02";

            unset($row['basura_img01']);
            unset($row['basura_img02']);
        }

        // var_dump($datos);

        return [
            'success' => true,
            'message' => 'Granulometria obtenida con éxito',
            'data' => $datos,
            'status' => 200
        ];
    }


    public function jsonDataEditarGranulometriaGreenbrierModal($request){

         $objConexion = new conexion();
        $sql = "SELECT g.*, m.cliente, m.*
            FROM granulometria AS g
            INNER JOIN maquinas AS m ON g.procesador = m.procesador_maq           
            WHERE m.cliente = 'GREENBRIER' and g.id = :id
            ORDER BY g.fecha_server DESC";

        $stmt = $objConexion->conectarDooble()->prepare($sql);
        $stmt->bindParam(':id', $request['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return [
                'success' => false,
                'message' => 'No hay registros',
                'status' => 400
            ];
        }

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ✅ Agregar URL de imagen dinámica
        foreach ($datos as &$row) {
            $id = $row['id']; // Asegúrate de tener 'id' en la tabla

            $row['imagen_url_1'] = $row['basura_img01'] ? "ver_imagen_granulometria.php?id=$id&campo=basura_img01" : null;
            $row['imagen_url_2'] = $row['basura_img02'] ? "ver_imagen_granulometria.php?id=$id&campo=basura_img02" : null;
            
            // $row['imagen_url_1'] ?? = "ver_imagen_granulometria.php?id=$id&campo=basura_img01";
            // $row['imagen_url_2'] = "ver_imagen_granulometria.php?id=$id&campo=basura_img02";

            unset($row['basura_img01']);
            unset($row['basura_img02']);
        }

        // var_dump($datos);

        return [
            'success' => true,
            'message' => 'Granulometria obtenida con éxito',
            'data' => $datos,
            'status' => 200
        ];

    }


    public function dataGranulometriaGreenbrierRecargasGranalla($request)
    {

        // return $request;
        date_default_timezone_set('America/Denver');
        $objConexion = new conexion();

        $sql = "SELECT g.fecha, g.carga_granalla, m.cliente,g.id, 'KG' AS unidad
            FROM granulometria AS g
            INNER JOIN maquinas AS m ON g.procesador = m.procesador_maq
            WHERE m.cliente = 'GREENBRIER'
              AND DATE(g.fecha) >= CURDATE() - INTERVAL 7 DAY and m.procesador_maq = {$request}
            ORDER BY g.fecha DESC";

        $stmt = $objConexion->conectarDooble()->prepare($sql);
        $stmt->execute();

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ✅ Agregar fila con fecha de hoy (solo si no existe ya en los datos)
        $fechaHoy = date('Y-m-d');
        // var_dump($fechaHoy);
        $yaExisteHoy = false;

        foreach ($datos as $fila) {
            if (date('Y-m-d', strtotime($fila['fecha'])) === $fechaHoy) {
                $yaExisteHoy = true;
                break;
            }
        }

        if (!$yaExisteHoy) {
            $datos[] = [
                'fecha' => $fechaHoy,
                'carga_granalla' => 0,
                'cliente' => 'GREENBRIER',
                'id' => 0,
                'unidad' => 'KG'

            ];
        }

        // Ordenar por fecha descendente
        usort($datos, function ($a, $b) {
            return strtotime($b['fecha']) - strtotime($a['fecha']);
        });

        // Si aún así no hay datos
        if (count($datos) == 0) {
            return [
                'success' => false,
                'message' => 'No hay registros',
                'status' => 400
            ];
        }

        return [
            'success' => true,
            'message' => 'Granulometría obtenida con éxito',
            'data' => $datos,
            'status' => 200
        ];
    }



    public function dataSelectorAlertasGreenbrier()
    {
        $objConexion = new conexion();
        $sql = "SELECT * FROM alerta_maquinas_tipos ";

        $stmt = $objConexion->conectarDooble()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // más explícito
    }


    public function dataGranulometriaReporteGreenbrier()
    {
        $objConexion = new conexion();
        $pdo = $objConexion->conectarDooble();

        // 🔹 Consulta principal sin alertas
        $sql = "SELECT 
                g.*, 
                m.cliente,
                m.nombre,
                CASE 
                    WHEN g.id_usuario_auth IS NOT NULL THEN 'Sí' 
                    ELSE 'No' 
                END AS autorizado
            FROM reporte_especial AS g
            INNER JOIN maquinas AS m ON g.fk_maquina = m.fkMaquina
            ORDER BY g.fecha_hora DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($datos)) {
            return [
                'success' => false,
                'message' => 'No hay registros',
                'status' => 400
            ];
        }

        // 🔄 Obtener alertas agrupadas por id_reporte
        $sqlAlertas = "SELECT * FROM alertas_maquina";
        $stmtAlertas = $pdo->prepare($sqlAlertas);
        $stmtAlertas->execute();
        $alertas = $stmtAlertas->fetchAll(PDO::FETCH_ASSOC);

        // Agrupar alertas por id_reporte
        $alertasPorReporte = [];
        foreach ($alertas as $alerta) {
            $idReporte = $alerta['id_reporte'];
            if (!isset($alertasPorReporte[$idReporte])) {
                $alertasPorReporte[$idReporte] = [];
            }
            $alertasPorReporte[$idReporte][] = $alerta;
        }

        // 🔄 Asignar alertas a cada reporte
        foreach ($datos as &$row) {
            unset($row['basura_img01'], $row['basura_img02']); // limpia imagenes
            $row['alertas'] = $alertasPorReporte[$row['id']] ?? []; // asigna array de alertas o vacío
        }

        return [
            'success' => true,
            'message' => 'Granulometría consultada con éxito',
            'data' => $datos,
            'status' => 200
        ];
    }

    public function crearReporteGreenbrier($request)
    {

        //  return $this->crearAlertaReporteGreenbrier($request, 1);;

        try {
            // 🔹 Decodificar JSON anidado
            $granulometria = json_decode($request['selectorGranulometriaGreenbrier'], true);

            // return  $alertaReporteAltaGreenbrier;
            // 🔹 Conexión


            $sql = "INSERT INTO reporte_especial (
            fk_cliente,
            fk_maquina,
            id_granulometria,
            fecha,
            comment_01,
            comment_02,
            comment_03,
            comment_04,
            usuario,
            nombre_usuario           
        ) VALUES (
            :fk_cliente,
            :fk_maquina,
            :id_granulometria,
            :fecha,
            :comment_01,
            :comment_02,
            :comment_03,
            :comment_04,
            :usuario,
            :nombre_usuario            
        )";



            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $objConexion = new conexion();
            $pdo = $objConexion->conectarDooble(); // 🔹 Se guarda una sola vez
            // var_dump($_SESSION["usuario"], $_SESSION['nombre'], $_SESSION["auth_reporte"]);
            $stmt = $pdo->prepare($sql);
            // 🔹 Bind de parámetros
            $stmt->bindParam(':fk_cliente', $granulometria['fkCliente']);
            $stmt->bindParam(':fk_maquina', $granulometria['fkMaquina']);
            $stmt->bindParam(':id_granulometria', $granulometria['id'], PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $request['txtFechaGranulometriaGreenbrier']);
            $stmt->bindParam(':comment_01', $request['comment_01']);
            $stmt->bindParam(':comment_02', $request['comment_02']);
            $stmt->bindParam(':comment_03', $request['comment_03']);
            $stmt->bindParam(':comment_04', $request['comment_04']);
            $stmt->bindParam(':usuario', $_SESSION["usuario"]);
            $stmt->bindParam(':nombre_usuario', $_SESSION['nombre']);
            // $stmt->bindParam(':id_usuario_auth', $_SESSION["id"]);
            // $stmt->bindParam(':id_usuario_auth', $_SESSION['id_usuario']); // o desde $request si lo envías

            $stmt->execute();

            // ✅ Esto ahora funcionará correctamente
            $reporteId = $pdo->lastInsertId();
            $alertaReporteAltaGreenbrier = $this->crearAlertaReporteGreenbrier($request, $reporteId);


            // var_dump($reporteId);



            // var_dump($alertaReporteAltaGreenbrier['message']);

            return [
                'success' => true,
                'message' => 'Reporte almacenado correctamente.' . '<br>' . $alertaReporteAltaGreenbrier['message'],
                // 'message' => 'Reporte almacenado correctamente.',
                'status' => 200
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'status' => 500
            ];
        }
    }


    public function crearAlertaReporteGreenbrier($request, $reporteId)
    {


        // return $request;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_usuario = $_SESSION['id'] ?? null;
        if (!$id_usuario) {
            return [
                'success' => false,
                'message' => 'No hay usuario en sesión.',
                'status' => 401
            ];
        }

        $objConexion = new conexion();
        $pdo = $objConexion->conectarDooble();

        $granulometria = json_decode($request['granulometria'], true);
        $fk_maquina = $granulometria['fkMaquina'] ?? null;

        if (!$fk_maquina) {
            return [
                'success' => false,
                'message' => 'No se encontró fk_maquina.',
                'status' => 400
            ];
        }

        $sql = "INSERT INTO alertas_maquina 
        (fk_maquina, activa, texto_01, urgencia, urgencia_num, id_usuario, id_reporte)
        VALUES 
        (:fk_maquina, :activa, :texto_01, :urgencia, :urgencia_num, :id_usuario, :id_reporte)";
        $stmt = $pdo->prepare($sql);

        $alertasRegistradas = 0;

        // 🟢 Primera alerta
        if (!empty($request['txtMensajeAlerta']) && !empty($request['tituloAlerta1'])) {
            $stmt->execute([
                ':fk_maquina'     => $fk_maquina,
                ':activa'         => $request['alerta'],
                ':texto_01'       => $request['txtMensajeAlerta'],
                ':urgencia'       => $request['tituloAlerta1'],
                ':urgencia_num'   => $this->mapUrgenciaTextoANumero($request['tituloAlerta1']),
                ':id_usuario'     => $id_usuario,
                ':id_reporte'     => $reporteId
            ]);
            $alertasRegistradas++;
        }

        // 🔵 Segunda alerta
        if (!empty($request['txtMensajeAlerta2']) && !empty($request['tituloAlerta2'])) {
            $stmt->execute([
                ':fk_maquina'     => $fk_maquina,
                ':activa'         => $request['alerta2'],
                ':texto_01'       => $request['txtMensajeAlerta2'],
                ':urgencia'       => $request['tituloAlerta2'],
                ':urgencia_num'   => $this->mapUrgenciaTextoANumero($request['tituloAlerta2']),
                ':id_usuario'     => $id_usuario,
                ':id_reporte'     => $reporteId
            ]);
            $alertasRegistradas++;
        }


        // 🔵 tercera alerta
        if (!empty($request['txtMensajeAlerta3']) && !empty($request['tituloAlerta3'])) {
            $stmt->execute([
                ':fk_maquina'     => $fk_maquina,
                ':activa'         => $request['alerta2'],
                ':texto_01'       => $request['txtMensajeAlerta2'],
                ':urgencia'       => $request['tituloAlerta3'],
                ':urgencia_num'   => $this->mapUrgenciaTextoANumero($request['tituloAlerta3']),
                ':id_usuario'     => $id_usuario,
                ':id_reporte'     => $reporteId
            ]);
            $alertasRegistradas++;
        }

        return [
            'success' => true,
            'message' => "Se registraron {$alertasRegistradas} alerta(s) correctamente."
        ];
    }

    public function actualizarAlertaReporteGreenbrier($request, $reporteId)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_usuario = $_SESSION['id'] ?? null;
        if (!$id_usuario) {
            return [
                'success' => false,
                'message' => 'No hay usuario en sesión.',
                'status' => 401
            ];
        }

        $objConexion = new conexion();
        $pdo = $objConexion->conectarDooble();

        $stmtUpdate = $pdo->prepare("
        UPDATE alertas_maquina SET
            activa = :activa,
            texto_01 = :texto_01,
            urgencia = :urgencia,
            urgencia_num = :urgencia_num,
            id_usuario = :id_usuario
        WHERE id = :id
    ");

        $actualizadas = 0;

        // 🟢 Primera alerta
        if (
            !empty($request['id_alerta_edicion']) &&
            !empty($request['txtMensajeAlertaEdicion']) &&
            !empty($request['tituloAlerta1Edicion'])
        ) {
            $urgencia1 = $this->obtenerUrgenciaPorTitulo($request['tituloAlerta1Edicion']);

            $stmtUpdate->execute([
                ':activa'       => $request['alertaEdicion'],
                ':texto_01'     => $request['txtMensajeAlertaEdicion'],
                ':urgencia'     => $urgencia1,
                ':urgencia_num' => $this->mapUrgenciaTextoANumero($urgencia1),
                ':id_usuario'   => $id_usuario,
                ':id'           => $request['id_alerta_edicion']
            ]);
            $actualizadas++;
        }

        // 🔵 Segunda alerta
        if (
            !empty($request['id_alerta_edicion2']) &&
            !empty($request['txtMensajeAlerta2Edicion']) &&
            !empty($request['tituloAlerta2Edicion'])
        ) {
            $urgencia2 = $this->obtenerUrgenciaPorTitulo($request['tituloAlerta2Edicion']);

            $stmtUpdate->execute([
                ':activa'       => $request['alerta2Edicion'],
                ':texto_01'     => $request['txtMensajeAlerta2Edicion'],
                ':urgencia'     => $urgencia2,
                ':urgencia_num' => $this->mapUrgenciaTextoANumero($urgencia2),
                ':id_usuario'   => $id_usuario,
                ':id'           => $request['id_alerta_edicion2']
            ]);
            $actualizadas++;
        }

        // 🔴 Tercera alerta
        if (
            !empty($request['id_alerta_edicion3']) &&
            !empty($request['txtMensajeAlerta3Edicion']) &&
            !empty($request['tituloAlerta3Edicion'])
        ) {
            $urgencia3 = $this->obtenerUrgenciaPorTitulo($request['tituloAlerta3Edicion']);

            $stmtUpdate->execute([
                ':activa'       => $request['alerta3Edicion'],
                ':texto_01'     => $request['txtMensajeAlerta3Edicion'],
                ':urgencia'     => $urgencia3,
                ':urgencia_num' => $this->mapUrgenciaTextoANumero($urgencia3),
                ':id_usuario'   => $id_usuario,
                ':id'           => $request['id_alerta_edicion3']
            ]);
            $actualizadas++;
        }

        return [
            'success' => true,
            'message' => "Se actualizaron {$actualizadas} alerta(s) correctamente."
        ];
    }



    private function obtenerUrgenciaPorTitulo($titulo)
    {
        $objConexion = new conexion();
        $pdo = $objConexion->conectarDooble();

        $sql = "SELECT urgencia FROM alerta_maquinas_tipos WHERE id = :titulo LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':titulo' => $titulo]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['urgencia'] : null;
    }





    private function mapUrgenciaTextoANumero($urgencia)
    {
        switch (strtoupper($urgencia)) {
            case 'ALTA':
                return 3;
            case 'MEDIA':
                return 2;
            case 'BAJA':
                return 1;
            default:
                return 0;
        }
    }

    public function autorizarReporteGreenbrier($request)
    {
        // return $request;
        try {

            // 🔹 Conexión
            $objConexion = new conexion();

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // 🔁 UPDATE solamente
            $sql = "UPDATE reporte_especial SET       
                    id_usuario_auth = :id_usuario_auth,
                    fecha_hora_auth = NOW()
                    WHERE id = :id";

            $stmt = $objConexion->conectarDooble()->prepare($sql);

            // 🔹 Bind de parámetros

            // $stmt->bindParam(':fecha', $request['txtFechaGranulometriaGreenbrier']);
            // $stmt->bindParam(':fecha_hora_auth', date('Y-m-d H:i:s'));
            $stmt->bindParam(':id_usuario_auth', $_SESSION['id']);
            $stmt->bindParam(':id', $request['idReporteGreenbrier'], PDO::PARAM_INT);

            $stmt->execute();

            return [
                'success' => true,
                'message' => 'Reporte actualizado correctamente.',
                'status' => 200
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'status' => 500
            ];
        }
    }


    public function editarReporteGreenbrierAutorizacion($request)
    {



        $idsAlertas = array(
            'id_alerta_edicion' => $request['id_alerta_edicion'],
            'id_alerta_edicion2' => $request['id_alerta_edicion2'],
            'id_alerta_edicion3' => $request['id_alerta_edicion3']
        );

        // $resultado = $this->actualizarAlertaReporteGreenbrier($request, $idsAlertas);
        // return $resultado;


        try {
            // 🔹 Decodificar JSON anidado
            // $granulometria = json_decode($request['selectorGranulometriaGreenbrier'], true);



            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // var_dump($_SESSION["usuario"], $_SESSION['nombre'], $_SESSION["auth_reporte"]);


            // 🔁 UPDATE solamente
            $sql = "UPDATE reporte_especial SET       
                    comment_01 = :comment_01,
                    comment_02 = :comment_02,
                    comment_03 = :comment_03,
                    comment_04 = :comment_04,
                    usuario = :usuario,
                    nombre_usuario = :nombre_usuario
                WHERE id = :id";


            // 🔹 Conexión
            $objConexion = new conexion();
            $pdo = $objConexion->conectarDooble(); // 🔹 Se guarda una sola vez            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':comment_01', $request['cometario_1']);
            $stmt->bindParam(':comment_02', $request['cometario_2']);
            $stmt->bindParam(':comment_03', $request['cometario_3']);
            $stmt->bindParam(':comment_04', $request['cometario_4']);
            $stmt->bindParam(':usuario', $_SESSION["usuario"]);
            $stmt->bindParam(':nombre_usuario', $_SESSION['nombre']);
            $stmt->bindParam(':id', $request['idReporteGreenbrier'], PDO::PARAM_INT);

            $stmt->execute();


            $resultado = $this->actualizarAlertaReporteGreenbrier($request, $idsAlertas);

            return [
                'success' => true,
                'message' => 'Reporte actualizado correctamente.',
                'status' => 200
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'status' => 500
            ];
        }
    }





    public function dataMaquinas()
    {
        $objConexion = new conexion();
        $sql = "SELECT * FROM maquinas";
        $stmt = $objConexion->conectarDooble()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function coberturaFurmula($request)
    {
        return $request['c_300'] + $request['c_212'] + $request['c_150'] + $request['c_850'] + $request['c_09'] + $request['c_05']  + $request['polvo'];
    }

    public function porcentaje_600_furmula($request, $cobertura)
    {
        return round(($request['c_600'] * 100) / ($request['c_600'] + $request['c_425'] + $cobertura), 2);
    }

    public function porcentaje_425_formula($request, $cobertura)
    {
        return round(($request['c_425'] * 100) / ($request['c_600'] + $request['c_425'] + $cobertura), 2);
    }

    public function insertarReporteGreenbrier($request)
    {
        // return $cargaGranallado;


        // return $request;
        $cobertura_furmula = mainGranulometria::coberturaFurmula($request);
        $porcentaje_600_furmula = mainGranulometria::porcentaje_600_furmula($request, $cobertura_furmula);
        $porcentaje_425_formula = mainGranulometria::porcentaje_425_formula($request, $cobertura_furmula);





        // var_dump('porcentaje_600_furmula', $porcentaje_600_furmula);
        // var_dump('porcentaje_425_formula', $porcentaje_425_formula);
        // var_dump('cobertura_furmula', $cobertura_furmula);
        // var_dump('session', $_SESSION['nombre']);

        // var_dump($request['basura_img01']);



        // Procesar imágenes
        // Inicializamos las variables como null por si no se envían imágenes
        $imagen1 = null;
        $imagen2 = null;

        // Verificamos si se ha enviado la imagen 1, si es un arreglo válido, si existe el archivo temporal, y si no excede 500 KB
        if (
            isset($request['basura_img01']) &&
            is_array($request['basura_img01']) &&
            isset($request['basura_img01']['tmp_name']) &&
            file_exists($request['basura_img01']['tmp_name']) &&
            $request['basura_img01']['size'] <= 512000
        ) {
            // Si todo es válido, cargamos el contenido binario de la imagen
            $imagen1 = file_get_contents($request['basura_img01']['tmp_name']);
        }

        // Misma validación para la imagen 2
        if (
            isset($request['basura_img02']) &&
            is_array($request['basura_img02']) &&
            isset($request['basura_img02']['tmp_name']) &&
            file_exists($request['basura_img02']['tmp_name']) &&
            $request['basura_img02']['size'] <= 512000
        ) {
            $imagen2 = file_get_contents($request['basura_img02']['tmp_name']);
        }


        $recargas_granallados = json_decode($request['recargas_granallados'], true);
        // var_dump($request['basura_img01']);
        // var_dump($request['basura_img02']);



        // return $request;

        try {

            $objConexion = new conexion();
            $sql = "INSERT INTO granulometria (
            fecha,
            nombre_maquina,
            c_05,
            c_09,
            c_150,
            c_212,
            c_300,
            c_425,            
            c_600,
            c_850,
            c_1180,
            c_1400,
            c_1700,
            c_2200,
            rug01,
            rug02,
            rug03,
            rug04,
            rug05,
            rug06,
            rug07,
            rug08,
            rug09,
            rug10,
            rug11,
            rug12,
            rug13,
            rug14,
            rug15,
            rug16,
            rug17,
            rug18,
            rug19,
            rug20,
            basura_N_der,
            basura_N_izq,
            basura_C_der,
            basura_C_izq,
            basura_S_der,
            basura_S_izq,
            basura_F_n,
            basura_F_s,
            vacio_silo_01,
            vacio_silo_02,
            basura_img01,
            basura_img02,
            cobertura,
            fkMaquina,
            fkCliente,
            porcentaje_600,
            porcentaje_425,
            procesador,
            usuario,
            carga_granalla
            ) VALUES 
            (
            :fecha,
            :nombre_maquina,
            :c_05,
            :c_09,
            :c_150,
            :c_212,
            :c_300,
            :c_425,           
            :c_600,
            :c_850,
            :c_1180,
            :c_1400,
            :c_1700,
            :c_2200,
            :rug01,
            :rug02,
            :rug03,
            :rug04,
            :rug05,
            :rug06,
            :rug07,
            :rug08,
            :rug09,
            :rug10,
            :rug11,
            :rug12,
            :rug13,
            :rug14,
            :rug15,
            :rug16,
            :rug17,
            :rug18,
            :rug19,
            :rug20,
            :basura_N_der,
            :basura_N_izq,
            :basura_C_der,
            :basura_C_izq,
            :basura_S_der,
            :basura_S_izq,
            :basura_F_n,
            :basura_F_s,
            :vacio_silo_01,
            :vacio_silo_02,
            :basura_img01,
            :basura_img02,
            :cobertura,
            :fkMaquina,
            :fkCliente,
            :porcentaje_600,
            :porcentaje_425,
            :procesador,
            :usuario,
            :carga_granalla)";
            $stmt = $objConexion->conectarDooble()->prepare($sql);
            $stmt->bindParam(':fecha', $request['fecha'], PDO::PARAM_STR);
            $stmt->bindParam(':nombre_maquina', $request['maquinaNombre'], PDO::PARAM_STR);
            $stmt->bindParam(':c_05', $request['c_05'], PDO::PARAM_STR);
            $stmt->bindParam(':c_09', $request['c_09'], PDO::PARAM_STR);
            $stmt->bindParam(':c_150', $request['c_150'], PDO::PARAM_STR);
            $stmt->bindParam(':c_212', $request['c_212'], PDO::PARAM_STR);
            $stmt->bindParam(':c_300', $request['c_300'], PDO::PARAM_STR);
            $stmt->bindParam(':c_425', $request['c_425'], PDO::PARAM_STR);
            $stmt->bindParam(':c_600', $request['c_600'], PDO::PARAM_STR);
            $stmt->bindParam(':c_850', $request['c_850'], PDO::PARAM_STR);
            $stmt->bindParam(':c_1180', $request['c_1180'], PDO::PARAM_STR);
            $stmt->bindParam(':c_1400', $request['c_1400'], PDO::PARAM_STR);
            $stmt->bindParam(':c_1700', $request['c_1700'], PDO::PARAM_STR);
            $stmt->bindParam(':c_2200', $request['c_2200'], PDO::PARAM_STR);
            $stmt->bindParam(':rug01', $request['rug01'], PDO::PARAM_STR);
            $stmt->bindParam(':rug02', $request['rug02'], PDO::PARAM_STR);
            $stmt->bindParam(':rug03', $request['rug03'], PDO::PARAM_STR);
            $stmt->bindParam(':rug04', $request['rug04'], PDO::PARAM_STR);
            $stmt->bindParam(':rug05', $request['rug05'], PDO::PARAM_STR);
            $stmt->bindParam(':rug06', $request['rug06'], PDO::PARAM_STR);
            $stmt->bindParam(':rug07', $request['rug07'], PDO::PARAM_STR);
            $stmt->bindParam(':rug08', $request['rug08'], PDO::PARAM_STR);
            $stmt->bindParam(':rug09', $request['rug09'], PDO::PARAM_STR);
            $stmt->bindParam(':rug10', $request['rug10'], PDO::PARAM_STR);
            $stmt->bindParam(':rug11', $request['rug11'], PDO::PARAM_STR);
            $stmt->bindParam(':rug12', $request['rug12'], PDO::PARAM_STR);
            $stmt->bindParam(':rug13', $request['rug13'], PDO::PARAM_STR);
            $stmt->bindParam(':rug14', $request['rug14'], PDO::PARAM_STR);
            $stmt->bindParam(':rug15', $request['rug15'], PDO::PARAM_STR);
            $stmt->bindParam(':rug16', $request['rug16'], PDO::PARAM_STR);
            $stmt->bindParam(':rug17', $request['rug17'], PDO::PARAM_STR);
            $stmt->bindParam(':rug18', $request['rug18'], PDO::PARAM_STR);
            $stmt->bindParam(':rug19', $request['rug19'], PDO::PARAM_STR);
            $stmt->bindParam(':rug20', $request['rug20'], PDO::PARAM_STR);
            $stmt->bindParam(':basura_N_der', $request['basura_N_der'], PDO::PARAM_STR);
            $stmt->bindParam(':basura_N_izq', $request['basura_N_izq'], PDO::PARAM_STR);
            $stmt->bindParam(':basura_C_der', $request['basura_C_der'], PDO::PARAM_STR);
            $stmt->bindParam(':basura_C_izq', $request['basura_C_izq'], PDO::PARAM_STR);
            $stmt->bindParam(':basura_S_der', $request['basura_S_der'], PDO::PARAM_STR);
            $stmt->bindParam(':basura_S_izq', $request['basura_S_izq'], PDO::PARAM_STR);
            $stmt->bindParam(':basura_F_n', $request['basura_F_n'], PDO::PARAM_STR);
            $stmt->bindParam(':basura_F_s', $request['basura_F_s'], PDO::PARAM_STR);
            $stmt->bindParam(':vacio_silo_01', $request['vacio_silo_01'], PDO::PARAM_STR);
            $stmt->bindParam(':vacio_silo_02', $request['vacio_silo_02'], PDO::PARAM_STR);
            $stmt->bindParam(':basura_img01', $imagen1, PDO::PARAM_LOB);
            $stmt->bindParam(':basura_img02', $imagen2, PDO::PARAM_LOB);
            $stmt->bindParam(':cobertura', $cobertura_furmula, PDO::PARAM_STR);
            $stmt->bindParam(':fkMaquina', $request['fkMaquina'], PDO::PARAM_STR);
            $stmt->bindParam(':fkCliente', $request['fkCliente'], PDO::PARAM_STR);
            $stmt->bindParam(':porcentaje_600', $porcentaje_600_furmula, PDO::PARAM_STR);
            $stmt->bindParam(':porcentaje_425', $porcentaje_425_formula, PDO::PARAM_STR);
            $stmt->bindParam(':procesador', $request['procesador_maq'], PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $request['usuario'], PDO::PARAM_STR);
            $stmt->bindParam(':carga_granalla', $recargas_granallados[0]['carga_granallado'], PDO::PARAM_STR);
            $stmt->execute();

            // $recargas_granallados = json_decode($request['recargas_granallados'], true);
            $cargaGranallado = $this->actualizarCargaGranallados($recargas_granallados);

            // var_dump($cargaGranallado);



            // Verificamos cuántas filas se han insertado
            if ($stmt->rowCount() > 0) {

                $array = [
                    'success' => true,
                    'message' => array(
                        'mensaje_Granalla' => 'Registro de granulometría exitoso',
                        'mensaje_Granallados_actualizados' => $cargaGranallado['message']
                    ),
                    'status' => 200,
                ];
            } else {
                $array = [
                    'success' => false,
                    'message' => 'Error en el registro favor de validar datos',
                    'status' => 400
                ];
            }

            return $array;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function actualizarCargaGranallados($request)
    {
        try {
            $total = count($request);
            $objConexion = new conexion();

            // SQL sin errores de sintaxis
            $sql = "UPDATE granulometria 
                SET carga_granalla = :carga_granalla 
                WHERE id = :id";

            // $stmt = $objConexion->conectarDooble()->prepare($sql);
            $stmt = $objConexion->conectarDooble()->prepare($sql);
            $registrosActualizados = 0;

            for ($i = 0; $i < $total; $i++) {
                $item = $request[$i];
                // var_dump($item);

                // Validar ID válido
                if (!empty($item['id']) && is_numeric($item['id'])) {
                    // Si tu array se llama carga_granallado, ajustamos:
                    $carga = $item['carga_granallado'] ?? null;
                    // var_dump($carga);

                    $stmt->bindParam(':carga_granalla', $carga, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $item['id'], PDO::PARAM_INT);
                    $stmt->execute();

                    $registrosActualizados += $stmt->rowCount();
                }
            }

            // Evaluar resultado
            if ($registrosActualizados > 0) {
                return [
                    'success' => true,
                    'message' => 'Recarga(s) de granallados actualizada(s) con éxito',
                    'status' => 200,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No se realizaron actualizaciones. Verifica los datos.',
                    'status' => 400,
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error de base de datos: ' . $e->getMessage(),
                'status' => 500,
            ];
        }
    }



    public function editarReporteGreenbrier($request)
    {


        // return $request;


        $imagen1 = null;
        $imagen2 = null;

        if (
            isset($request['basura_img01']) &&
            is_array($request['basura_img01']) &&
            isset($request['basura_img01']['tmp_name']) &&
            file_exists($request['basura_img01']['tmp_name']) &&
            $request['basura_img01']['size'] <= 512000
        ) {
            $imagen1 = file_get_contents($request['basura_img01']['tmp_name']);
        }

        if (
            isset($request['basura_img02']) &&
            is_array($request['basura_img02']) &&
            isset($request['basura_img02']['tmp_name']) &&
            file_exists($request['basura_img02']['tmp_name']) &&
            $request['basura_img02']['size'] <= 512000
        ) {
            $imagen2 = file_get_contents($request['basura_img02']['tmp_name']);
        }

        try {
            $objConexion = new conexion();
            $sql = "UPDATE granulometria SET
            polvo = :polvo,
            fecha = :fecha,
            nombre_maquina = :nombre_maquina,
            c_05 = :c_05,
            c_09 = :c_09,
            c_150 = :c_150,
            c_212 = :c_212,
            c_300 = :c_300,
            c_425 = :c_425,
            c_600 = :c_600,
            c_850 = :c_850,
            c_1180 = :c_1180,
            c_1400 = :c_1400,
            c_1700 = :c_1700,
            c_2200 = :c_2200,
            rug01 = :rug01,
            rug02 = :rug02,
            rug03 = :rug03,
            rug04 = :rug04,
            rug05 = :rug05,
            rug06 = :rug06,
            rug07 = :rug07,
            rug08 = :rug08,
            rug09 = :rug09,
            rug10 = :rug10,
            rug11 = :rug11,
            rug12 = :rug12,
            rug13 = :rug13,
            rug14 = :rug14,
            rug15 = :rug15,
            rug16 = :rug16,
            rug17 = :rug17,
            rug18 = :rug18,
            rug19 = :rug19,
            rug20 = :rug20,
            basura_N_der = :basura_N_der,
            basura_N_izq = :basura_N_izq,
            basura_C_der = :basura_C_der,
            basura_C_izq = :basura_C_izq,
            basura_S_der = :basura_S_der,
            basura_S_izq = :basura_S_izq,
            basura_F_n = :basura_F_n,
            basura_F_s = :basura_F_s,
            vacio_silo_01 = :vacio_silo_01,
            vacio_silo_02 = :vacio_silo_02,
            cobertura = :cobertura,
            fkMaquina = :fkMaquina,
            fkCliente = :fkCliente,
            porcentaje_600 = :porcentaje_600,
            porcentaje_425 = :porcentaje_425,
            procesador = :procesador,
            usuario = :usuario" .
                ($imagen1 !== null ? ", basura_img01 = :basura_img01" : "") .
                ($imagen2 !== null ? ", basura_img02 = :basura_img02" : "") .
                " WHERE id = :id";

            $stmt = $objConexion->conectarDooble()->prepare($sql);

            $stmt->bindParam(':id', $request['id'], PDO::PARAM_INT);
            $stmt->bindParam(':polvo', $request['polvo'],);
            $stmt->bindParam(':fecha', $request['fecha']);
            $stmt->bindParam(':nombre_maquina', $request['maquinaNombre']);
            $stmt->bindParam(':c_05', $request['c_05']);
            $stmt->bindParam(':c_09', $request['c_09']);
            $stmt->bindParam(':c_150', $request['c_150']);
            $stmt->bindParam(':c_212', $request['c_212']);
            $stmt->bindParam(':c_300', $request['c_300']);
            $stmt->bindParam(':c_425', $request['c_425']);
            $stmt->bindParam(':c_600', $request['c_600']);
            $stmt->bindParam(':c_850', $request['c_850']);
            $stmt->bindParam(':c_1180', $request['c_1180']);
            $stmt->bindParam(':c_1400', $request['c_1400']);
            $stmt->bindParam(':c_1700', $request['c_1700']);
            $stmt->bindParam(':c_2200', $request['c_2200']);

            for ($i = 1; $i <= 20; $i++) {
                $key = sprintf('rug%02d', $i);
                $stmt->bindParam(":$key", $request[$key]);
            }

            $stmt->bindParam(':basura_N_der', $request['basura_N_der']);
            $stmt->bindParam(':basura_N_izq', $request['basura_N_izq']);
            $stmt->bindParam(':basura_C_der', $request['basura_C_der']);
            $stmt->bindParam(':basura_C_izq', $request['basura_C_izq']);
            $stmt->bindParam(':basura_S_der', $request['basura_S_der']);
            $stmt->bindParam(':basura_S_izq', $request['basura_S_izq']);
            $stmt->bindParam(':basura_F_n', $request['basura_F_n']);
            $stmt->bindParam(':basura_F_s', $request['basura_F_s']);
            $stmt->bindParam(':vacio_silo_01', $request['vacio_silo_01']);
            $stmt->bindParam(':vacio_silo_02', $request['vacio_silo_02']);
            $stmt->bindParam(':cobertura', $request['cobertura']);
            $stmt->bindParam(':fkMaquina', $request['fkMaquina']);
            $stmt->bindParam(':fkCliente', $request['fkCliente']);
            $stmt->bindParam(':porcentaje_600', $request['porcentaje_600']);
            $stmt->bindParam(':porcentaje_425', $request['porcentaje_425']);
            $stmt->bindParam(':procesador', $request['procesador_maq']);
            $stmt->bindParam(':usuario', $request['usuario']);

            if ($imagen1 !== null) {
                $stmt->bindParam(':basura_img01', $imagen1, PDO::PARAM_LOB);
            }
            if ($imagen2 !== null) {
                $stmt->bindParam(':basura_img02', $imagen2, PDO::PARAM_LOB);
            }

            $stmt->execute();


            $recargas_granallados = json_decode($request['recargas_granallados'], true);
            $cargaGranallado = $this->actualizarCargaGranallados($recargas_granallados);


            return [
                'success' => true,
                'message' => array(
                    'mensaje_Granalla' => 'Registro de granulometría exitoso',
                    'mensaje_Granallados_actualizados' => $cargaGranallado['message']
                ),
                'status' => 200
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage(),
                'status' => 500
            ];
        }
    }



    public function insertar($request)
    {


        // return $request;
        $cobertura_furmula = mainGranulometria::coberturaFurmula($request);
        $porcentaje_600_furmula = mainGranulometria::porcentaje_600_furmula($request, $cobertura_furmula);
        $porcentaje_425_formula = mainGranulometria::porcentaje_425_formula($request, $cobertura_furmula);


        // var_dump('porcentaje_600_furmula', $porcentaje_600_furmula);
        // var_dump('porcentaje_425_formula', $porcentaje_425_formula);
        // var_dump('cobertura_furmula', $cobertura_furmula);
        // var_dump('session', $_SESSION['nombre']);


        try {

            $objConexion = new conexion();
            $sql = "INSERT INTO granulometria (
            fecha,
            nombre_maquina,
            c_05,
            c_09,
            c_150,
            c_212,
            c_300,
            c_425,            
            c_600,
            c_850,
            c_1180,
            c_1400,
            c_1700,
            c_2200,
            cobertura,
            fkMaquina,
            fkCliente,
            porcentaje_600,
            porcentaje_425,
            procesador,
            usuario
            ) VALUES 
            (
            :fecha,
            :nombre_maquina,
            :c_05,
            :c_09,
            :c_150,
            :c_212,
            :c_300,
            :c_425,           
            :c_600,
            :c_850,
            :c_1180,
            :c_1400,
            :c_1700,
            :c_2200,
            :cobertura,
            :fkMaquina,
            :fkCliente,
            :porcentaje_600,
            :porcentaje_425,
            :procesador,
            :usuario)";
            $stmt = $objConexion->conectarDooble()->prepare($sql);
            $stmt->bindParam(':fecha', $request['fecha'], PDO::PARAM_STR);
            $stmt->bindParam(':nombre_maquina', $request['maquinaNombre'], PDO::PARAM_STR);
            $stmt->bindParam(':c_05', $request['c_05'], PDO::PARAM_STR);
            $stmt->bindParam(':c_09', $request['c_09'], PDO::PARAM_STR);
            $stmt->bindParam(':c_150', $request['c_150'], PDO::PARAM_STR);
            $stmt->bindParam(':c_212', $request['c_212'], PDO::PARAM_STR);
            $stmt->bindParam(':c_300', $request['c_300'], PDO::PARAM_STR);
            $stmt->bindParam(':c_425', $request['c_425'], PDO::PARAM_STR);
            $stmt->bindParam(':c_600', $request['c_600'], PDO::PARAM_STR);
            $stmt->bindParam(':c_850', $request['c_850'], PDO::PARAM_STR);
            $stmt->bindParam(':c_1180', $request['c_1180'], PDO::PARAM_STR);
            $stmt->bindParam(':c_1400', $request['c_1400'], PDO::PARAM_STR);
            $stmt->bindParam(':c_1700', $request['c_1700'], PDO::PARAM_STR);
            $stmt->bindParam(':c_2200', $request['c_2200'], PDO::PARAM_STR);
            $stmt->bindParam(':cobertura', $cobertura_furmula, PDO::PARAM_STR);
            $stmt->bindParam(':fkMaquina', $request['fkMaquina'], PDO::PARAM_STR);
            $stmt->bindParam(':fkCliente', $request['fkCliente'], PDO::PARAM_STR);
            $stmt->bindParam(':porcentaje_600', $porcentaje_600_furmula, PDO::PARAM_STR);
            $stmt->bindParam(':porcentaje_425', $porcentaje_425_formula, PDO::PARAM_STR);
            $stmt->bindParam(':procesador', $request['procesador_maq'], PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $request['usuario'], PDO::PARAM_STR);
            $stmt->execute();

            // Verificamos cuántas filas se han insertado
            if ($stmt->rowCount() > 0) {

                $array = [
                    'success' => true,
                    'message' => 'Granulometria registrada con exito',
                    'status' => 200,
                ];
            } else {
                $array = [
                    'success' => false,
                    'message' => 'Error en el registro favor de validar datos',
                    'status' => 400
                ];
            }

            return $array;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function editar($request)
    {

        // return $request;


        $cobertura_furmula = mainGranulometria::coberturaFurmula($request);
        $porcentaje_600_furmula = mainGranulometria::porcentaje_600_furmula($request, $cobertura_furmula);
        $porcentaje_425_formula = mainGranulometria::porcentaje_425_formula($request, $cobertura_furmula);

        $objConexion = new conexion();
        $sql = "UPDATE granulometria SET
        c_05 = :c_05,
        c_09 = :c_09,
        c_150 = :c_150,
        c_212 = :c_212,
        c_300 = :c_300,
        c_425 = :c_425,
        c_600 = :c_600,
        c_850 = :c_850,
        c_1180 = :c_1180,
        c_1400 = :c_1400,
        c_1700 = :c_1700,
        c_2200 = :c_2200,
        polvo = :polvo,
        cobertura = :cobertura,
        porcentaje_600 = :porcentaje_600,
        porcentaje_425 = :porcentaje_425
        WHERE id = :idGranulometria";
        $stmt = $objConexion->conectarDooble()->prepare($sql);
        $stmt->bindParam(':c_05', $request['c_05'], PDO::PARAM_STR);
        $stmt->bindParam(':c_09', $request['c_09'], PDO::PARAM_STR);
        $stmt->bindParam(':c_150', $request['c_150'], PDO::PARAM_STR);
        $stmt->bindParam(':c_212', $request['c_212'], PDO::PARAM_STR);
        $stmt->bindParam(':c_300', $request['c_300'], PDO::PARAM_STR);
        $stmt->bindParam(':c_425', $request['c_425'], PDO::PARAM_STR);
        $stmt->bindParam(':c_600', $request['c_600'], PDO::PARAM_STR);
        $stmt->bindParam(':c_850', $request['c_850'], PDO::PARAM_STR);
        $stmt->bindParam(':c_1180', $request['c_1180'], PDO::PARAM_STR);
        $stmt->bindParam(':c_1400', $request['c_1400'], PDO::PARAM_STR);
        $stmt->bindParam(':c_1700', $request['c_1700'], PDO::PARAM_STR);
        $stmt->bindParam(':c_2200', $request['c_2200'], PDO::PARAM_STR);
        $stmt->bindParam(':polvo', $request['polvo'], PDO::PARAM_STR);
        $stmt->bindParam(':cobertura', $cobertura_furmula, PDO::PARAM_STR);
        $stmt->bindParam(':porcentaje_600', $porcentaje_600_furmula, PDO::PARAM_STR);
        $stmt->bindParam(':porcentaje_425', $porcentaje_425_formula, PDO::PARAM_STR);
        $stmt->bindParam(':idGranulometria', $request['idGranulometria'], PDO::PARAM_STR);



        $stmt->execute();

        // Verificamos cuántas filas se han insertado
        if ($stmt->rowCount() > 0) {

            $array = [
                'success' => true,
                'message' => 'Granulometria actualizada con exito',
                'status' => 200,
            ];
        } else {
            $array = [
                'success' => false,
                'message' => 'Error en el registro favor de validar datos',
                'status' => 400
            ];
        }

        return $array;
    }

    public function dataGranulometria()
    {
        $objConexion = new conexion();
        $sql = "SELECT g.*, m.cliente 
        FROM granulometria AS g
        INNER JOIN maquinas AS m ON g.procesador = m.procesador_maq order by g.fecha DESC;
        ";
        $stmt = $objConexion->conectarDooble()->prepare($sql);
        $stmt->execute();


        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($datos as &$row) {

            unset($row['basura_img01']);
            unset($row['basura_img02']);
        }

        if ($stmt->rowCount() == 0) {
            $array = [
                'success' => false,
                'message' => 'No hay registros',
                'status' => 400
            ];
            return $array;
        }

        $array = [
            'success' => true,
            'message' => 'Granulometria editada con exito',
            'data' => $datos,
            'status' => 200
        ];

        return $array;
    }


    //     public function dataGranulometriaGreenbrier()
    //     {
    //         $objConexion = new conexion();
    //         $sql = "SELECT g.*, m.cliente
    // FROM granulometria AS g
    // INNER JOIN maquinas AS m ON g.procesador = m.procesador_maq
    // WHERE m.cliente = 'GREENBRIER' -- ← Aquí filtras por cliente
    // ORDER BY g.fecha_server DESC;
    //         ";
    //         $stmt = $objConexion->conectarDooble()->prepare($sql);
    //         $stmt->execute();


    //         var_dump($stmt->fetchAll());

    //         if ($stmt->rowCount() == 0) {
    //             $array = [
    //                 'success' => false,
    //                 'message' => 'No hay registros',
    //                 'status' => 400
    //             ];
    //             return $array;
    //         }

    //         $array = [
    //             'success' => true,
    //             'message' => 'Granulometria editada con exito',
    //             'data' => $stmt->fetchAll(),
    //             'status' => 200
    //         ];

    //         return $array;
    //     }


    public function dataGranulometriaGreenbrier()
    {
        $objConexion = new conexion();
        $sql = "SELECT g.*, m.cliente, m.*
            FROM granulometria AS g
            INNER JOIN maquinas AS m ON g.procesador = m.procesador_maq
            WHERE m.cliente = 'GREENBRIER'
            ORDER BY g.fecha_server DESC";

        $stmt = $objConexion->conectarDooble()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return [
                'success' => false,
                'message' => 'No hay registros',
                'status' => 400
            ];
        }

        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ✅ Agregar URL de imagen dinámica
        foreach ($datos as &$row) {
            $id = $row['id']; // Asegúrate de tener 'id' en la tabla
            $row['imagen_url_1'] = "ver_imagen_granulometria.php?id=$id&campo=basura_img01";
            $row['imagen_url_2'] = "ver_imagen_granulometria.php?id=$id&campo=basura_img02";

            unset($row['basura_img01']);
            unset($row['basura_img02']);
        }

        // var_dump($datos);

        return [
            'success' => true,
            'message' => 'Granulometria obtenida con éxito',
            'data' => $datos,
            'status' => 200
        ];
    }



    public function dataGranulometriaSelector($request)
    {

        //  var_dump($request);
        $Sql = "SELECT c_05, c_09, c_150, c_212, c_300, c_425, c_600, c_850, c_1180, c_1400, c_1700, c_2200,fkCliente, fkMaquina,nombre_maquina,fecha, id  FROM granulometria
        WHERE fecha >= NOW() - INTERVAL 5 DAY and fkMaquina = :fkMaquina
        ORDER BY fecha DESC
        LIMIT 5;
        ";


        $objConexion = new conexion();

        $stmt = $objConexion->conectarDooble()->prepare($Sql);
        $stmt->bindParam(':fkMaquina', $request, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();



        // var_dump($request);
        // var_dump($stmt->fetchAll());
        if ($stmt->rowCount() == 0) {
            $array = [
                'success' => false,
                'message' => 'No hay registros',
                'status' => 400
            ];
            return $array;
        }
        // $stmt = null;
    }
}
