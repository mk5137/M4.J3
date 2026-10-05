<?php
header('Content-Type: application/json; charset=utf-8');

$zadania = [
    ["id" => 1, "nazwa" => "Zrobić zakupy", "wykonane" => false],
    ["id" => 2, "nazwa" => "Nauczyć się PHP", "wykonane" => true],
    ["id" => 3, "nazwa" => "Napisać kod w JS", "wykonane" => false]
];

echo json_encode($zadania, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Lista Zadań</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <h1>Moja Lista Zadań</h1>

  <div class="controls">
    <input type="text" id="szukaj" class="input-szukaj" placeholder="Szukaj zadania...">
  </div>

  <ul id="lista" class="lista-zadan"></ul>

  
  <script>
    const danePoczatkowe = <?= json_encode($poczatekZadan, JSON_UNESCAPED_UNICODE) ?>;
  </script>
  <script src="script.js"></script>
</body>
</html>