<?php
// session_start();

require_once "conexion.php";
class mainGranulometria
{
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
            'data' => $stmt->fetchAll(),
            'status' => 200
        ];

        return $array;
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
