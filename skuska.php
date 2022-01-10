<?php
require "pripojenie.php";
require "pracovanie_s_databazou/vyberanieDatabaza.php";

$pracovanieDatabaza = new vyberanieDatabaza();

if(isset($pripojenie)) {
    $pracovanieDatabaza->pocetKat($pripojenie);
    for($i = 0; $i < $pracovanieDatabaza->getPocetKategorii(); $i++) {
        $pracovanieDatabaza->vyberKategoriu($pripojenie, $i);
        echo $pracovanieDatabaza->getNazovKategorie();
    }
}

?>

