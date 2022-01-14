<?php
require "../../pripojenie.php";
require "javaScripts/mazanie.js";

$user = $_REQUEST['user'];

if(isset($pripojenie)) {
    $selectKomentare = $pripojenie->prepare("select email, text_odpoved, cas_odpovede from odpovede_clanky order by cas_odpovede DESC limit ?,1");
    for ($i = 0; $i < 4; $i++) {
        $email = "";
        $text_odpoved = "";
        $cas_odpovede = "";
        $selectKomentare->bind_param('i', $i);
        $selectKomentare->execute();
        $selectKomentare->store_result();
        $selectKomentare->bind_result($email, $text_odpoved, $cas_odpovede);
        $selectKomentare->fetch();
        echo "<div id='.$i.'>";
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
                            echo "<td><a onclick='odstranenie()' href='#'>Zmazanie</a></td>";
                        echo "</tr>";
                    }
            echo "</table>";
        echo "</div>";
    }
}