<?php
require "../../pripojenie.php";
require "../../pracovanie_s_databazou/vyberanieVkladanieDatabaza.php";

$stranka = $_REQUEST['stranka'];
$nazov = $_REQUEST['nazov'];

$dajPocetOdpovedi = new vyberanieVkladanieDatabaza();
if(isset($pripojenie)) {
    $pocet = $dajPocetOdpovedi->dajPocetKomentarovPostu($pripojenie, $nazov);
    if($stranka * 4 == $pocet + 4) {
        $stranka -= 1;
    }
    $modulo = $pocet % 4;
    $pocet /= 4;
    if($modulo != 0) {
        $pocet = floor($pocet);
        $pocet +=1;
    }
    for ($i = 1; $i <= $pocet; $i++) {
        if($stranka == $i) {
            echo '<a id="aktivneCislo"> '.$i.' </a>';
        } else {
            echo '<a href="#" onclick="strankovanie(\'' . $i . '\', \'' . $nazov . '\')"> '.$i.' </a>';
        }
    }
}