<?php
session_start();
session_destroy(); // Destruye la sesión

echo json_encode(["status" => "session_closed"]);
exit();
?>