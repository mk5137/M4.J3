<?php
$godzina = (int)date('H');

if ($godzina >= 6 && $godzina < 18) {
    $powitanie = "Dzień dobry!";
} else {
    $powitanie = "Dobry wieczór!";
}

$cytaty = [
    "Najlepszy sposób na przewidzenie przyszłości to jej stworzenie.",
    "Każda wielka podróż zaczyna się od pierwszego kroku.",
    "Cierpliwość, wytrwałość i pot tworzą niepokonaną kombinację sukcesu.",
    "Prostota jest szczytem wyrafinowania."
];

$losowyKlucz = array_rand($cytaty);
$wylosowanyCytat = $cytaty[$losowyKlucz];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamiczna Karta Powitalna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h1><?php echo $powitanie; ?></h1>
        <p class="quote">„<?php echo $wylosowanyCytat; ?>”</p>
        <button id="themeToggle">Zmień motyw</button>
        <button onclick="location.reload();">Losuj inny cytat</button>
    </div>
    <script src="script.js"></script>
</body>
</html>