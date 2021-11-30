<?php
require "pripojenie.php";
$selectPocet = $pripojenie->prepare("SELECT count(?) from kategorie");
$nazov="nazov_kategorie";
$selectPocet->bind_param('s', $nazov);
if($selectPocet->execute()) {
    $selectPocet->store_result();
    $selectPocet->bind_result($pocetRiadkov);
    $selectPocet->fetch();
    echo $selectPocet->num_rows();
}