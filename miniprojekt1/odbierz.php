<?php
header("Content-Type: application/json; charset=UTF-8");

$response = [
    "status" => "error",
    "message" => "",
    "errors" => []
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $imie = trim($_POST["imie"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $wiadomosc = trim($_POST["wiadomosc"] ?? "");

    if ($imie === "" || strlen($imie) < 2) {
        $response["errors"]["imie"] = "Imię musi mieć co najmniej 2 znaki.";
    }

    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["errors"]["email"] = "Podano niepoprawny adres e-mail.";
    }

    if ($wiadomosc === "") {
        $response["errors"]["wiadomosc"] = "Wiadomość nie może być pusta.";
    }

    if (empty($response["errors"])) {
        $response["status"] = "success";
        $response["message"] = "Dziękujemy, " . htmlspecialchars($imie, ENT_QUOTES, "UTF-8") . "! Wiadomość została wysłana.";
    } else {
        $response["message"] = "Proszę poprawić błędy w formularzu.";
    }
} else {
    $response["message"] = "Nieprawidłowa metoda żądania.";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);