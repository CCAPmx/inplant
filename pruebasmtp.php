<?php
$host = 'smtp.office365.com';
$port = 587;
$timeout = 40;

echo "Conectando a $host:$port ...<br>";

$fp = fsockopen($host, $port, $errno, $errstr, $timeout);

if (!$fp) {
    echo "❌ No se pudo conectar: $errstr ($errno)";
    exit;
}

echo "✅ Conexión TCP abierta.<br>";

// Leer banner del servidor
$response = fgets($fp, 512);
echo "📥 Respuesta inicial: " . htmlspecialchars($response) . "<br>";

// Enviar EHLO
$cmd = "EHLO localhost\r\n";
fwrite($fp, $cmd);
echo "📤 Comando: EHLO localhost<br>";

// Leer respuesta del servidor al EHLO
while ($line = fgets($fp, 512)) {
    echo "📥 " . htmlspecialchars($line) . "<br>";
    if (strpos($line, 'STARTTLS') !== false) {
        echo "🔐 El servidor soporta STARTTLS<br>";
    }
    if (substr($line, 3, 1) != "-") {
        break; // Fin de respuesta multilinea
    }
}

// Enviar QUIT para cerrar conexión correctamente
fwrite($fp, "QUIT\r\n");
fclose($fp);

echo "🔚 Conexión cerrada.<br>";
?>
