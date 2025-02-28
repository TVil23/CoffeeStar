<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $group_class = htmlspecialchars($_POST['group_class']);
    
    if ($email && strlen($password) >= 8) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(16));
        
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, group_class, token) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $hashed_password, $group_class, $token])) {
            $confirm_link = "http://yourdomain.com/confirm.php?token=$token";
            mail($email, "Bestätigen Sie Ihre Registrierung", "Klicken Sie auf den folgenden Link: $confirm_link");
            echo "Registrierung erfolgreich! Bitte prüfen Sie Ihre E-Mails.";
        } else {
            echo "Fehler bei der Registrierung!";
        }
    } else {
        echo "Ungültige Eingabe!";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrierung</h1>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Schul-E-Mail" required>
            <input type="password" name="password" placeholder="Passwort" required>
            <input type="text" name="group_class" placeholder="Gruppe/Klasse (z. B. IT22)">
            <button type="submit" class="button">Registrieren</button>
        </form>
    </div>
</body>
</html>