<?php
include 'parametrosconex.php';
class Conexion{
    static public function conectar()
    {
        $servername = HOST;
        $username = USER;
        $password = PASSWORD;
        $dbname = DATABASE;
        $link= new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $link->exec("set names utf8");
        return $link;
    }
}