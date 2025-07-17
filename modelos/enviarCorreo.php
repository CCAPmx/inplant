<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once 'conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->SMTPDebug = 0; // Depuración activa
$mail->Debugoutput = 'html'; // Salida bonita

$entorno = 'auto';

try {
    if ($entorno === 'local' || ($entorno === 'auto' && in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1', 'inplant.test']))) {
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@lersan.com';
        $mail->Password = 'D3v3lop3rl3rs4n*';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('no-reply@lersan.com', 'INPLANT');
        $env = 'LOCAL';
    } else {
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->Port = 25;
        $mail->SMTPAuth = false;
        $mail->setFrom('no-reply@inplant.tech', 'INPLANT');
        $env = 'HOSTING';
    }

    $fkMaquina = $_POST['fkMaquina'] ?? null;
    if (!$fkMaquina) {
        throw new Exception("No se proporcionó fkMaquina.");
    }

    $objConexion = new conexion();
    $sql = "SELECT email_TO, email_CC, email_CCO, nombre FROM maquinas WHERE fkMaquina = :fkMaquina";
    $stmt = $objConexion->conectarDooble()->prepare($sql);
    $stmt->bindParam(':fkMaquina', $fkMaquina, PDO::PARAM_STR);
    $stmt->execute();

    $datos = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$datos) {
        throw new Exception("Máquina no encontrada.");
    }

    $nombre_maquina = $datos['nombre'];

    // Agregar destinatarios TO
    $totalDestinatarios = 0;

    if (!empty($datos['email_TO'])) {
        $destinosTO = explode(',', $datos['email_TO']);
        foreach ($destinosTO as $correo) {
            $correoLimpio = trim($correo);
            if (filter_var($correoLimpio, FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($correoLimpio);
                $totalDestinatarios++;
            } else {
                throw new Exception("Correo inválido en email_TO: $correoLimpio");
            }
        }
    }

    if (!empty($datos['email_CC'])) {
        $destinosCC = explode(',', $datos['email_CC']);
        foreach ($destinosCC as $correo) {
            $correoLimpio = trim($correo);
            if (filter_var($correoLimpio, FILTER_VALIDATE_EMAIL)) {
                $mail->addCC($correoLimpio);
                $totalDestinatarios++;
            } else {
                throw new Exception("Correo inválido en email_CC: $correoLimpio");
            }
        }
    }

    if (!empty($datos['email_CCO'])) {
        $destinosCCO = explode(',', $datos['email_CCO']);
        foreach ($destinosCCO as $correo) {
            $correoLimpio = trim($correo);
            if (filter_var($correoLimpio, FILTER_VALIDATE_EMAIL)) {
                $mail->addBCC($correoLimpio);
                $totalDestinatarios++;
            } else {
                throw new Exception("Correo inválido en email_CCO: $correoLimpio");
            }
        }
    }

    if ($totalDestinatarios === 0) {
        throw new Exception("No se especificaron destinatarios válidos.");
    }

    // Adjuntar PDF recibido
    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['type'] === 'application/pdf' && $_FILES['archivo_pdf']['size'] > 0) {
        $nombreArchivo = $_FILES['archivo_pdf']['name'];
        $tmpPath = $_FILES['archivo_pdf']['tmp_name'];
        $mail->addAttachment($tmpPath, $nombreArchivo);
    } else {
        throw new Exception("No se recibió un archivo PDF válido o el archivo está vacío.");
    }

    // Extraer fecha del nombre de archivo
    $sinExtension = pathinfo($nombreArchivo, PATHINFO_FILENAME);

    if (preg_match('/(\d{2})_(\d{2})_(\d{4})$/', $sinExtension, $matches)) {
        $fechaFormateada = "{$matches[1]}/{$matches[2]}/{$matches[3]}";
    } else {
        $fechaFormateada = date('d/m/Y');
    }

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = "[INPLANT] Reporte de Granulometría - Máquina: $nombre_maquina - $fechaFormateada";
    $mail->Body = "
        <div style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>
            <p>Estimado usuario,</p>
            <p>Se adjunta el <strong>reporte de granulometría</strong> correspondiente a la máquina <strong>$nombre_maquina -$fechaFormateada</strong>.</p>
            <br>
            
        </div>
    ";

    $mail->send();
    echo "✅ Correo enviado correctamente.";

} catch (Exception $e) {
    echo "❌ Error al enviar el correo: {$mail->ErrorInfo} - {$e->getMessage()}";
}

