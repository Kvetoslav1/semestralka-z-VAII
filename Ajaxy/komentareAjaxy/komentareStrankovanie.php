<?php
require "../../pripojenie.php";

session_start();
$stranka = $_REQUEST['str'];
$nazov = $_REQUEST['post'];
$user = $_SESSION['Email'];

if(isset($pripojenie) && $stranka >= 1) {
    $selectKomentare = $pripojenie->prepare("select email, text_odpoved, cas_odpovede from odpovede_clanky where nadpis_postu = ? order by cas_odpovede DESC limit ?,1");
    $stranka *= 4;
    for ($i = $stranka - 4; $i < $stranka; $i++) {
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
                echo "<td><a onclick='' href='#'>Zmazanie</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
}