<?php
require "../../pripojenie.php";

$stranka = $_REQUEST['str'];
$user = $_REQUEST['user'];

if(isset($pripojenie) && $stranka >= 1) {
    $selectKomentare = $pripojenie->prepare("select email, text_odpoved, cas_odpovede from odpovede_clanky order by cas_odpovede DESC limit ?,1");
    $stranka *= 4;
    for ($i = $stranka - 4; $i < $stranka; $i++) {
        $email = "";
        $text_odpoved = "";
        $cas_odpovede = "";
        $selectKomentare->bind_param('i', $i);
        $selectKomentare->execute();
        $selectKomentare->store_result();
        $selectKomentare->bind_result($email, $text_odpoved, $cas_odpovede);
        $selectKomentare->fetch();
        if($email != "" && $text_odpoved != "" && $cas_odpovede != "") {
            echo "<table style='margin-top: 20px'>";
                    echo "<td>Odpoveď napísal: $email</td>";
                    echo "<td>Dátum napísania: $cas_odpovede</td>";
                echo "<tr>";
                    echo "<td>";
                        echo $text_odpoved;
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