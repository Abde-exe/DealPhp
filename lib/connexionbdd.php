<?php

$adresse = "mysql:host=localhost;dbname=deal;charset=utf8mb4";
$login = "root";
$password = "root";

// $adresse = "mysql:host=localhost;dbname=id18928070_deal;charset=utf8mb4";
// $login = "id18928070_root";
// $password = "&gGt9@B2@w3i";

$connexion = new PDO($adresse, $login, $password);
