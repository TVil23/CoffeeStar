<?php
$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Datenbank und Tabelle erstellen
    $sql = "
        CREATE DATABASE IF NOT EXISTS $dbname
        DEFAULT CHARACTER SET utf8mb4 
        COLLATE utf8mb4_general_ci;

        USE $dbname;

        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            group_class VARCHAR(50),
            verified TINYINT(1) DEFAULT 0,
            token VARCHAR(255)
        );
    ";

    $pdo->exec($sql);
  
} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}
?>