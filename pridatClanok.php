<?php
require "pripojenie.php";
include "pracovanie_s_databazou/vyberanieDatabaza.php";
include "pracovanie_s_databazou/clanky_posty/pridavanieClanku.php";

session_start();
if(!isset($_SESSION['Email'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="styles/zaklad.css" rel="stylesheet" type="text/css">
    <link href="styles/gridStyle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div class="telo">

    <div class="odsadenie">

        <?php require "zakladnaStranka/header.php"; ?>

        <form method="post" enctype="application/x-www-form-urlencoded">
            <div id="clanokCreate" class="gridy">
                <h2 class="header" style="grid-column: 1/4;">Vytváranie článku</h2>
                <span id="resolution-change" style="grid-row: 2; grid-column: 1/4">Pri vytvárani článku zvoľte správnu kategóriu do ktorej článok patrí.
                    V opačnom prípade bude váš článok zmazaný administrátorom stránky.</span>
                <span style="grid-row: 3" class="bold">Výber kategórie:</span>
                <select class="vstup" name="kategoriaClanku">
                    <?php
                    $vyberanie = new vyberanieDatabaza();
                    if(isset($pripojenie)) {
                        $vyberanie->dajKategorie($pripojenie);
                    }
                    ?>
                </select>
                <span style="grid-row: 4;" class="bold">Zadajte názov článku:</span>
                <input name="nazovClanku" class="vstup" required minlength="3" maxlength="40" placeholder="Názov článku">
                <span style="grid-row: 5;" class="bold">Nadpis článku:</span>
                <input name="nadpisClanku" required minlength="3" maxlength="60" type="text" style="grid-row: 5" class="vstup" placeholder="Nadpis článku">
                <button type="submit" style="grid-row: 6; grid-column: 2" class="btn-reg-log">Vytvoriť článok</button>
            </div>
        </form>
        <?php

        if(isset($_POST['kategoriaClanku']) && strlen($_POST['nazovClanku']) > 3 && strlen($_POST['nadpisClanku']) > 3) {
            //vytiahnutie ID kategorie
            $pridajClanok = new pridavanieClanku();
            if(isset($pripojenie)) {
                $pridajClanok->pridajClanok($pripojenie, $_POST['nazovClanku'], $_SESSION['Email'], $vyberanie->getIdKategorie(), $_POST['nadpisClanku']);
                echo "<script type='text/javascript'>alert('Článok nebol vytvorený!');</script>";
            }
        }
        ?>

        <footer class="koniec">
            ©2021 Author: Kvetoslav Varga
            <p><a href="mailto:kvetko189@gmail.com">kvetko189@gmail.com</a></p>
        </footer>

    </div>

</div>

</body>

</html>