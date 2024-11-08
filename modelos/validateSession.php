<?php
header('Content-Type: application/json');
session_start();



$host = 'https://fms.lersan.com/fmi/data/v2/validateSession';
$payloadName = '';
$token = $_SESSION["ccap"];
$requestAll = get_dataAll($host, $token, $payloadName);
$jsonData = json_encode($requestAll);

$data = json_decode($jsonData, true); // true convierte a arreglo en lugar de objeto

if (isset($data['messages']) && is_array($data['messages'])) {
    $firstMessage = $data['messages'][0]; // Accede al primer mensaje en el arreglo

    echo $firstMessage['code'];

    if ($firstMessage['code'] == 0) {

        return true;
    } else {

        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finalmente, destruye la sesión
        session_destroy();

        // Redirige al usuario a la página de inicio
        // header("Location: /ingreso.php"); // Cambia a la ruta de tu página de inicio
        // exit();
        return false;
    }
} else {
    echo "No se encontraron mensajes.";
}



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
