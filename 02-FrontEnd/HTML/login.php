<?php
require 'config.php';
session_start();

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password']) && $user['verified']) {
        $_SESSION['user_id'] = $user['id'];
        $success_message = "Anmeldung erfolgreich! Du wirst weitergeleitet...";
        header("refresh:2;url=/bitzer/CoffeeStar%207/CoffeeStar/02-FrontEnd/HTML/menu.html");
    } else {
        $error_message = "Falsche Anmeldedaten oder Konto nicht bestätigt!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoffeeStar - login</title>
    <link rel="stylesheet" href="CSS/style-l.css">
</head>
<body>

    <div class="container">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <a href="start.html">Start</a>
            <a href="menu.html">Menu</a>
            <a href="cart.html">Cart</a>
            <a href="about.html">About</a>
            <img src="img/logo.jpg" alt="Logo" class="nav-logo">
        </nav>
    <div class="container">
        <h1>Registrierung</h1>


        <!-- Login Form -->
        <div class="login-form">
            <h1>Login</h1>
            
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success_message)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="email">E-Mail:</label>
                    <input type="email" id="email" name="email" placeholder="Deine E-Mail-Adresse" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Passwort:</label>
                    <input type="password" id="password" name="password" placeholder="Dein Passwort" required>
                </div>
                
                <button type="submit" class="button">Einloggen</button>
            </form>
        </div>
       

        <!-- Contact Information -->
        <div class="contact-box">
            <p>Contact us at: CoffeStar@bapfit.de | Phone: +123 456 7890</p>
        </div>
    </div>
</body>
</html>