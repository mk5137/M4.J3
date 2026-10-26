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
        $telefon = trim($_POST["telefon"] ?? "");
        $data_kontaktu = trim($_POST["data_kontaktu"] ?? "");
        $haslo = $_POST["haslo"] ?? "";
        $temat = trim($_POST["temat"] ?? "");
        $wiadomosc = trim($_POST["wiadomosc"] ?? "");
        $zgoda = $_POST["zgoda"] ?? "";

        if ($imie === "" || strlen($imie) < 2) {
            $errors[] = "Imię jest wymagane i musi mieć min. 2 znaki.";
        }

        if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Podano niepoprawny adres e-mail.";
        }

        if ($telefon === "" || !preg_match("/^[0-9+\s-]{9,15}$/", $telefon)) {
            $errors[] = "Wpisz prawidłowy numer telefonu (9-15 cyfr).";
        }

        if ($data_kontaktu === "") {
            $errors[] = "Proszę wybrać datę kontaktu.";
        }

        if (strlen($haslo) < 4) {
            $errors[] = "Hasło musi posiadać co najmniej 4 znaki.";
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
            echo "<h2>Podsumowanie danych</h2>";
            echo "<p style='color: #4ade80; text-align: center; font-weight: bold; margin-bottom: 15px;'>Formularz został pomyślnie przetworzony!</p>";
            
            echo "<table class='result-table'>";
            echo "<tr><th>Imię</th><td>" . htmlspecialchars($imie, ENT_QUOTES, "UTF-8") . "</td></tr>";
            echo "<tr><th>E-mail</th><td>" . htmlspecialchars($email, ENT_QUOTES, "UTF-8") . "</td></tr>";
            echo "<tr><th>Telefon</th><td>" . htmlspecialchars($telefon, ENT_QUOTES, "UTF-8") . "</td></tr>";
            echo "<tr><th>Data kontaktu</th><td>" . htmlspecialchars($data_kontaktu, ENT_QUOTES, "UTF-8") . "</td></tr>";
            echo "<tr><th>Hasło (długość)</th><td>" . strlen($haslo) . " znaków</td></tr>";
            echo "<tr><th>Temat</th><td>" . htmlspecialchars($temat, ENT_QUOTES, "UTF-8") . "</td></tr>";
            echo "<tr><th>Wiadomość</th><td>" . nl2br(htmlspecialchars($wiadomosc, ENT_QUOTES, "UTF-8")) . "</td></tr>";
            echo "</table>";
        } else {
            echo "<h2 style='color: #fb7185;'>Wystąpiły błędy:</h2><ul style='margin-bottom: 20px;'>";
            foreach ($errors as $error) {
                echo "<li style='color: #fb7185; margin-left: 20px; margin-bottom: 5px;'>" . htmlspecialchars($error, ENT_QUOTES, "UTF-8") . "</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "<p>Nieprawidłowe żądanie.</p>";
    }
    ?>
    
    <button onclick="window.location.href='index.php';">Powrót do formularza</button>
</div>

</body>
</html>