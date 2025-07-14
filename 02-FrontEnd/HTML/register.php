<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrieren</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
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
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
            border-radius: 10px;
        }

        h1 {
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
            box-shadow: 0 0 5px rgba(99,79,72,0.3);
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

        /* Responsive Design */
        @media screen and (max-width: 480px) {
            .container {
                width: 90%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrierung</h1>

        <?php
        require 'config.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        require 'PHPMailer/src/Exception.php';

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        $error_message = '';
        $success_message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $group_class = htmlspecialchars($_POST['group_class']);

    // Erlaubte Domains erweitert
    $allowed_domains = ['@bappassau.de', '@bapfit.de', '@bappassau.onmicrosoft.com'];
    $valid_domain = false;

    if ($email) {
        foreach ($allowed_domains as $domain) {
            if (str_ends_with($email, $domain)) {
                $valid_domain = true;
                break;
            }
        }
    }

    if (!$valid_domain) {
        $error_message = "Bitte registriere dich nur mit einer E-Mail-Adresse von @bappassau.de, @bapfit.de oder @bappassau.onmicrosoft.com.";
    } elseif (strlen($password) < 8) {
                $error_message = "Das Passwort muss mindestens 8 Zeichen lang sein.";
            } else {
                // Check ob Email schon existiert
                $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $checkStmt->execute([$email]);

                if ($checkStmt->rowCount() > 0) {
                    $error_message = "Diese E-Mail-Adresse ist bereits registriert.";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $token = bin2hex(random_bytes(16)); // Zufälliger Token
                    $verified = 0;

                    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, group_class, token, verified) VALUES (?, ?, ?, ?, ?, ?)");
                    if ($stmt->execute([$name, $email, $hashedPassword, $group_class, $token, $verified])) {
                        $confirm_link = "http://localhost/bitzer/CoffeeStar%207/CoffeeStar/03-BackEnd/Login-System/confirm.php?token=$token";

                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = 'mail.gmx.net';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'coffeestarconfirmation@gmx.de';
                            $mail->Password = 'Hallöchen123!'; 
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            $mail->setFrom('coffeestarconfirmation@gmx.de', 'CoffeeStar');
                            $mail->addAddress($email, $name);
                            $mail->isHTML(true);
                            $mail->Subject = 'Verifiziere deine Registrierung';
                            $mail->Body = "Hallo $name,<br><br>
                                bitte verifiziere deine Registrierung mit einem Klick auf diesen Link:<br>
                                <a href='$confirm_link'>$confirm_link</a><br><br>
                                LG <br>CoffeeStar-Team";

                            $mail->send();
                            $success_message = "Registrierung erfolgreich! Bitte prüfe deine E-Mails.";
                        } catch (Exception $e) {
                            $error_message = "Registrierung gespeichert, aber die E-Mail konnte nicht gesendet werden.<br>Fehler: {$mail->ErrorInfo}";
                        }
                    } else {
                        $error_message = "Fehler bei der Registrierung!";
                    }
                }
            }
        }

        // Ausgabe der Meldungen
        if (!empty($error_message)) {
            echo '<div class="error-message">' . htmlspecialchars($error_message) . '</div>';
        }

        if (!empty($success_message)) {
            echo '<div class="success-message">' . htmlspecialchars($success_message) . '</div>';
        }
        ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Name" required>
            </div>

            <div class="form-group">
                <label for="email">Schul-E-Mail:</label>
                <input type="email" id="email" name="email" placeholder="E-Mail (z.B. ...@bappassau.de)" required>
            </div>

            <div class="form-group">
                <label for="password">Passwort (min. 8 Zeichen):</label>
                <input type="password" id="password" name="password" placeholder="Passwort" required>
            </div>

            <div class="form-group">
                <label for="group_class">Gruppe/Klasse (optional):</label>
                <input type="text" id="group_class" name="group_class" placeholder="z.B. IT22">
            </div>

            <button type="submit" class="button">Registrieren</button>
            <button type="button" onclick="window.location.href='login.php'" class="button" style="background:#5a453e; margin-top: 10px;">Einloggen</button>
        </form>
    </div>
</body>
</html>
