<?php
require "pripojenie.php";
$selectPocet = $pripojenie->prepare("SELECT count(?) from kategorie");
$nazov="nazov_kategorie";
$selectPocet->bind_param('s', $nazov);
if($selectPocet->execute()) {
    $selectPocet->store_result();
    $selectPocet->bind_result($pocetRiadkov);
    $selectPocet->fetch();
    for ($i = 0; $i < $pocetRiadkov; $i++) {
        $selectKategoria = $pripojenie->prepare("SELECT nazov_kategorie from kategorie LIMIT ?,1");
        $selectKategoria->bind_param('i', $i);
        if($selectKategoria->execute()) {
            $selectKategoria->store_result();
            $selectKategoria->bind_result($nazovKategorie);
            $selectKategoria->fetch();
            echo $nazovKategorie;
        }
    }
}