<?php
require 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("UPDATE users SET verified = 1 WHERE token = ?");
    if ($stmt->execute([$token]) && $stmt->rowCount() > 0) {
        echo "Konto erfolgreich bestätigt!";
        echo '<a href="login.php">Jetzt einloggen</a>';
    } else {
        echo "Ungültiger Bestätigungslink!";
    }
}
?>