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
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoffeeStar - Login</title>
    <style>
        /* Vollständige Styles - alles inline */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #634f48;
            min-height: 100vh;
        }

        .container {
            width: 80%;
            max-width: 500px;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 10px;
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: center; 
            align-items: center;
            background: #333;
            padding: 15px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .nav-logo {
            width: 60px;
            height: auto;
            display: block;
            border-radius: 50%;
        }

        /* Login Form */
        .login-form {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 20px 0;
        }

        .login-form h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 2.2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #634f48;
            box-shadow: 0 0 5px rgba(99, 79, 72, 0.3);
        }

        .button {
            background: #634f48;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
            margin-top: 10px;
        }

        .button:hover {
            background: #5a453e;
        }

        .error-message {
            color: #d32f2f;
            background: #ffebee;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #d32f2f;
        }

        .success-message {
            color: #2e7d32;
            background: #e8f5e8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #2e7d32;
        }

        /* Contact Box */
        .contact-box {
            background: #333;
            color: white;
            width: 100%;
            text-align: center;
            padding: 15px;
            box-sizing: border-box;
            margin-top: 20px;
            border-radius: 5px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            .navbar a {
                font-size: 0.9rem;
                padding: 10px 8px;
            }

            .login-form {
                padding: 20px;
            }

            .login-form h1 {
                font-size: 1.8rem;
            }
        }

        @media screen and (max-width: 480px) {
            .navbar a {
                font-size: 0.8rem;
                padding: 8px 5px;
            }

            .login-form h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <img src="img/logo.jpg" alt="Logo" class="nav-logo">
        </nav>

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