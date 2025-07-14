<?php
require 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Benutzer anhand des Tokens suchen
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Nutzer als verifiziert markieren und Token entfernen
        $update = $pdo->prepare("UPDATE users SET verified = 1, token = NULL WHERE id = ?");
        if ($update->execute([$user['id']])) {
            echo "<h2> Bestätigung erfolgreich!</h2>";
            echo "<p>Dein Account wurde aktiviert. Du kannst dich jetzt <a href='login.php'>einloggen</a>.</p>";
        } else {
            echo "<h2> Fehler beim Bestätigen des Accounts.</h2>";
        }
    } else {
        echo "<h2> Ungültiger oder bereits verwendeter Bestätigungslink.</h2>";
    }
} else {
    echo "<h2> Kein Bestätigungs-Token angegeben.</h2>";
}
?>