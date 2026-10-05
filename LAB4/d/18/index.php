<?php
header('Content-Type: application/json; charset=utf-8');

$zadania = [
    ["id" => 1, "nazwa" => "Zrobić zakupy", "wykonane" => false],
    ["id" => 2, "nazwa" => "Nauczyć się PHP", "wykonane" => true],
    ["id" => 3, "nazwa" => "Napisać kod w JS", "wykonane" => false]
];

echo json_encode($zadania, JSON_UNESCAPED_UNICODE);
?>