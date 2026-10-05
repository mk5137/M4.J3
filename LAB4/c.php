/*Zadanie 11*/
<?php
$technologie = ["HTML", "CSS", "JavaScript", "PHP", "MySQL"];

echo "<ul>\n";
foreach ($technologie as $tech) {
    echo "  <li>" . htmlspecialchars($tech) . "</li>\n";
}
echo "</ul>";
?>

/*Zadanie 12*/
<?php
$produkty = [
    ["id" => 1, "nazwa" => "Klawiatura", "cena" => 149.99, "dostepny" => true],
    ["id" => 2, "nazwa" => "Myszka", "cena" => 89.00, "dostepny" => false],
    ["id" => 3, "nazwa" => "Monitor", "cena" => 750.50, "dostepny" => true]
];

echo "<ul>\n";
foreach ($produkty as $produkt) {
    $cenaFormat = number_format($produkt['cena'], 2, ',', ' ');
    $stan = $produkt['dostepny'] ? "dostępny" : "niedostępny";
    echo "  <li>" . htmlspecialchars($produkt['nazwa']) . " - " . $cenaFormat . " PLN (" . $stan . ")</li>\n";
}
echo "</ul>";
?>

/*Zadanie 13*/
<?php
$produktyDostepne = array_filter($produkty, function ($produkt) {
    return $produkt['dostepny'] === true;
});

$iloscDostepnych = count($produktyDostepne);

echo "Liczba dostępnych produktów: " . $iloscDostepnych;
?>

/*Zadanie 14*/
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwaZadania = isset($_POST['nazwa_zadania']) ? trim($_POST['nazwa_zadania']) : '';

    if (empty($nazwaZadania)) {
        echo "Nazwa zadania nie może być pusta!";
    } else {
        echo "Dodano zadanie: " . htmlspecialchars($nazwaZadania);
    }
}
?>


/*Zadanie 15*/
<?php
session_start();

if (!isset($_SESSION['zadania'])) {
    $_SESSION['zadania'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noweZadanie = isset($_POST['nazwa_zadania']) ? trim($_POST['nazwa_zadania']) : '';
    
    if (!empty($noweZadanie)) {
        $_SESSION['zadania'][] = $noweZadanie;
    }
}
?>


/*Zadanie 16*/
<?php
header('Content-Type: application/json; charset=utf-8');

$dane = [
    ["id" => 1, "nazwa" => "Zadanie 1", "status" => "wykonane"],
    ["id" => 2, "nazwa" => "Zadanie 2", "status" => "aktywne"]
];

echo json_encode($dane, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
?>


