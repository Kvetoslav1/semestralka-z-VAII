<?php
require "pripojenie.php";
require "pracovanie_s_databazou/praca_s_pouzivatelom/upravaUdajov.php";
session_start();
if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
}
$uprava = new upravaUdajov();
 if(isset($_POST['zmazanie']) && isset($pripojenie)) {
     $uprava->odstranUcet($pripojenie, $_SESSION['Email']);
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

        <div>
            <form method="post" enctype="application/x-www-form-urlencoded">
                <div id="userInfo" class="gridy" style="grid-row: 2/3">
                    <?php
                    $chybnaHlaska = null;
                    if(strlen($_POST['zmenaMena']) >= 3 && isset($pripojenie)){
                            //kontrola ci nie je meno zabrate
                        if($uprava->zmenMeno($pripojenie, $_POST['zmenaMena'], $_SESSION['Email'])) {
                            header("Refresh:0");
                            $message = "Meno bolo úspešne zmenené.";
                            echo "<script type='text/javascript'>alert('$message');</script>";
                        } else {
                            $chybnaHlaska = "Meno sa už používa";
                            ?>
                            <span class="all-check" style="grid-row: 3; grid-column: 2/4"> <?php echo $chybnaHlaska ?></span>
                            <?php
                        }
                    }
                    if(strlen($_POST['zmenaHesla']) >= 8 && strlen($_POST['zmenaPotvrHesla']) >= 8 && isset($pripojenie)) {
                        if($uprava->zmenHeslo($pripojenie, $_SESSION['Email'], $_POST['zmenaHesla'], $_POST['zmenaPotvrHesla'])) {
                            $message = "Heslo bolo úspešne zmenené.";
                            echo "<script type='text/javascript'>alert('$message');</script>";
                        } else {
                            $chybnaHlaska = "Heslá sa nezhodujú!";
                            ?>
                            <span class="all-check" style="grid-row: 7; grid-column: 2/4"> <?php echo $chybnaHlaska ?></span>
                            <?php
                        }
                    }
                    ?>
                    <h2 class="header" style="grid-column: 1/4;">Údaje aktuálne prihláseného používateľa.</h2>
                    <span id="resolution-change" style="grid-column: 1/4; grid-row: 2/3">
                        Ak chcete zmeniť vaše aktuálne údaje, tak napíšte nové údaje to textových polí a potvrdte zmeny
                    stlačením tlačidla na potvrdenie zmien.</span>
                    <span style="grid-row: 3;" class="bold">Používateľove meno:</span>
                    <input class="vstup" style="grid-row: 3; grid-column: 2" name="zmenaMena" type="text"
                           placeholder="Nové pouzivatelské meno" minlength="3" maxlength="20">
                    <span style="grid-row: 4">Meno musí mať minimálne 3 znaky a maximálne 20 znakov</span>
                    <span style="grid-row: 5" class="bold">Zmena hesla: </span>
                    <input class="vstup" style="grid-row: 5; grid-column: 2" name="zmenaHesla" type="password" pattern=".{8,}" placeholder="Nové heslo">
                    <span style="grid-row: 6">Ak chcete zmeniť vaše aktuálne heslo tak musíte potvrdiť nové heslo. Heslo musí mať minimálne 8 znakov</span>
                    <span style="grid-row: 7" class="bold">Potvrdenie nového hesla:</span>
                    <input class="vstup" style="grid-row: 7; grid-column: 2" name="zmenaPotvrHesla" type="password" pattern=".{8,}" placeholder="Potvrdenie nového hesla">
                    <button style="grid-row: 8; grid-column: 2/3; max-width: 130px;" class="btn-reg-log">Potvrdenie zmien</button>
                </div>
            </form>


            <form method="post" enctype="application/x-www-form-urlencoded">
                <div class="gridy" id="odstranenie-uctu" style="grid-row: 3">
                    <h2 class="header" style="grid-column: 1/4;">Zmazanie účtu.</h2>
                    <span id="resolution-change" style="grid-column: 1/4; grid-row: 2/3">
                        Ak naozaj chcete zmazať svoj účet tak sa spolu s ním zmažú aj všetky články, ktoré ste vytvorili
                    a aj odpovede, ktoré ste napísali. Ak si naozaj prajete zmazať účet kliknite na tlačidlo ZMAZAŤ ÚČET.</span>
                    <button name="zmazanie" type="submit" style="grid-column: 2/3; max-width: 130px" class="btn-reg-log" onclick="potvrdenieOdstranenia()">Zmazanie účtu</button>
                </div>
            </form>
        </div>


        <footer class="koniec">
            ©2021 Author: Kvetoslav Varga
            <p><a href="mailto:kvetko189@gmail.com">kvetko189@gmail.com</a></p>
        </footer>

    </div>

</div>

</body>

</html>