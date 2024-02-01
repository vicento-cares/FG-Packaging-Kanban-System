<?php
$host = 'localhost'; $user = 'root'; $password = ''; $database = 'fg_packaging_debug'; $port = 3306;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$database", $user, $password);
    // set the PDO error mode to exception
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>