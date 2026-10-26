<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podsumowanie formularza</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $errors = [];

        
        $imie = trim($_POST["imie"] ?? "");
        
        $email = trim($_POST["email"] ?? "");
        $temat = trim($_POST["temat"] ?? "");
        $wiadomosc = trim($_POST["wiadomosc"] ?? "");
        
        $zgoda = $_POST["zgoda"] ?? "";

        
        if ($imie === "" || strlen($imie) < 2) {
            $errors[] = "Imię jest wymagane i musi mieć co najmniej 2 znaki.";
        }

        
        if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Podano niepoprawny adres e-mail.";
        }

        if ($temat === "") {
            $errors[] = "Należy wybrać temat wiadomości.";
        }

        if ($wiadomosc === "") {
            $errors[] = "Wiadomość nie może być pusta.";
        }

        
        if ($zgoda !== "tak") {
            $errors[] = "Wymagana jest akceptacja regulaminu.";
        }

        
        if (empty($errors)) {
            echo "<h2>Podziękowanie</h2>";
            echo "<p style='color: green; font-weight: bold;'>Formularz został wysłany pomyślnie!</p><br>";
            
            
            echo "<p><strong>Imię:</strong> " . htmlspecialchars($imie, ENT_QUOTES, "UTF-8") . "</p>";
            echo "<p><strong>E-mail:</strong> " . htmlspecialchars($email, ENT_QUOTES, "UTF-8") . "</p>";
            echo "<p><strong>Temat:</strong> " . htmlspecialchars($temat, ENT_QUOTES, "UTF-8") . "</p>";
            echo "<p><strong>Wiadomość:</strong> " . nl2br(htmlspecialchars($wiadomosc, ENT_QUOTES, "UTF-8")) . "</p>";
        } else {
            echo "<h2 style='color: red;'>Wystąpiły błędy:</h2><ul>";
            foreach ($errors as $error) {
                echo "<li style='color: red; margin-left: 20px;'>" . htmlspecialchars($error, ENT_QUOTES, "UTF-8") . "</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "<p>Nieprawidłowe żądanie.</p>";
    }
    ?>
    <br>
    <a href="index.php" style="display: block; text-align: center; color: #007bff;">Powrót do formularza</a>
</div>

</body>
</html>