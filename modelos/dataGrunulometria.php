<?php
 
 
 $host = 'localhost';
 $dbname = 'lersanco_lersan';
 $username = 'lersanco_lersan';
 $password = 'Q&h[)#[%C&{K';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}