<?php
require "../../pripojenie.php";
require "../../pracovanie_s_databazou/vyberanieVkladanieDatabaza.php";

session_start();
$stranka = $_GET['stranka'];
$nazov =  $_GET['nazov'];

$user = $_SESSION['Email'];

$dajPocetOdpovedi = new vyberanieVkladanieDatabaza();

if(isset($pripojenie) && $stranka >= 1) {
    $pocet = $dajPocetOdpovedi->dajPocetKomentarovPostu($pripojenie, $nazov);
    $selectKomentare = $pripojenie->prepare("select email, text_odpoved, cas_odpovede from odpovede_clanky where nadpis_postu = ? order by cas_odpovede DESC limit ?,1");
    $poradie = $stranka *4;
    if($stranka * 4 == $pocet + 4) {
        $stranka -= 1;
        $poradie -= 4;
    }
    for ($i = $poradie - 4; $i < $poradie; $i++) {
        $email = "";
        $text_odpoved = "";
        $cas_odpovede = "";
        $selectKomentare->bind_param('si', $nazov, $i);
        $selectKomentare->execute();
        $selectKomentare->store_result();
        $selectKomentare->bind_result($email, $text_odpoved, $cas_odpovede);
        $selectKomentare->fetch();
        if($email != "" && $text_odpoved != "" && $cas_odpovede != "") {
            echo "<table style='grid-row: 4' class='odpovede'>";
                echo "<tr class='odpovedRiadok'>";
                    echo "<th>Odpoveď napísal: $email</th>";
                echo "</tr>";

                echo "<tr class='odpovedRiadok'>";
                    echo "<th>Dátum napísania: $cas_odpovede</th>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td>";
                        echo "<textarea class='textAreaOdpovede' readonly disabled>$text_odpoved</textarea>";
                    echo "</td>";
                echo "</tr>";

            if($user == $email) {
                echo "<tr>";
                echo "<td>";
                    echo '<a onclick="zmazanieKomentaru(\'' . $cas_odpovede . '\',\'' . $_GET['stranka'] . '\',\'' . $nazov . '\')" href="#" >Zmazanie</a>';
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
}