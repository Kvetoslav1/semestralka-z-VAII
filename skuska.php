<?php
require "pripojenie.php";
session_start();
$selectMeno = $pripojenie->prepare("SELECT meno FROM pouzivatel where email = ?");
$selectMeno->bind_param('s', $_SESSION['Email']);
if($selectMeno->execute()) {
    $selectMeno->store_result();
    $selectMeno->bind_result($menoPouzivatel);
    $selectMeno->fetch();
    echo $menoPouzivatel;
} else {
    echo "Nepodarilo sa vykonat select";
}

