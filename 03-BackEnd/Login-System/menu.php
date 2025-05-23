<?php
require 'config.php';

$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
    $sql = "
        CREATE TABLE IF NOT EXISTS items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            `group` VARCHAR(50),
            count VARCHAR(100)        );
    ";
    $pdo->exec($sql);


    $sql = "
        INSERT INTO items (id, name, `group`, count)
        VALUES 
            (1, 'Americano', 'Hot Coffee', 100),
            (2, 'Cafe Latte', 'Hot Coffee', 100),
            (3, 'Cappuccino', 'Hot Coffee', 100),
            (4, 'Espresso', 'Hot Coffee', 100),
            (5, 'Macchiato', 'Hot Coffee', 100),
            (6, 'Mocha', 'Hot Coffee', 100),
            (7, 'Cold-Brew', 'Cold Coffee', 100),
            (8, 'Frappuchino', 'Cold Coffee', 100),
            (9, 'Iced-Americano', 'Cold Coffee', 100),
            (10, 'Iced-Latte', 'Cold Coffee', 100),
            (11, 'Mazagran', 'Cold Coffee', 100),
            (12, 'Cheesecake', 'Baked Good', 100),
            (13, 'Cinnamon-Roll', 'Baked Good', 100),
            (14, 'Croissant', 'Baked Good', 100),
            (15, 'Krapfen', 'Baked Good', 100);
    ";
    $pdo->exec($sql);

} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage()); 
}
?>
