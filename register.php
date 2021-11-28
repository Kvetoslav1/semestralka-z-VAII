<?php
require "reg.php";
require "pripojenie.php";
session_start();
if(isset($_SESSION['Email'])) {
    header("Location: index.php");
}
$reg = null;
if(isset($_POST['UserName'])) {
    $reg = new reg();
    $reg->setMeno($_POST['UserName']);
    $reg->setEmail($_POST['Email']);
    $reg->setHeslo($_POST['Password']);
    $reg->setPotvrHeslo($_POST['ConfirmPassword']);

    /*$servername = "semestralka-DB-server-1";
    $username = "root";
    $password = "password";
    $database = "Database";

// Create connection
    $pripojenie = new mysqli($servername, $username, $password, $database);

// Check connection
    if ($pripojenie->connect_error) {
        die("Connection failed: " . $pripojenie->connect_error);
    }*/
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="zaklad.css" rel="stylesheet" type="text/css">
    <link href="loginStyle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div class="telo">

    <div class="odsadenie">

        <div>
            <img src="space1.jpg" class="slideShow" alt="Image not found">
            <img src="space2.jpg" class="slideShow" alt="Image not found">
            <img src="space3.jpg" class="slideShow" alt="Image not found">
            <script src="slideShowScript.js"></script>
        </div>

        <div class="btn-group">
            <button onclick="document.location='index.php'">Články/Podpora</button>
            <button onclick="document.location='info.php'">Info</button>
            <button onclick="document.location='register.php'"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrácia</button>
            <button onclick="document.location='login.php'"><i class="fa fa-sign-in" aria-hidden="true"></i> Prihlásenie</button>
        </div>

        <form method="post" enctype="application/x-www-form-urlencoded">
            <div id="register" class="gridy">
                <h2 class="header" style="grid-column: 1/4;">Registrácia</h2>
                <span id="resolution-change">
                    Berte na vedomie, že musíte uviesť platnú e-mailovú adresu.
                    Na túto e-mailovú adresu vám bude zaslaný mail, ktorý je potrebný na aktiváciu účtu.</span>

                <span style="grid-area: 3/1; grid-row: 3" class="bold">Uživateľské meno:</span>
                <input name="UserName" style="grid-row: 3;" type="text" placeholder="Username" required class="vstup" minlength="3" maxlength="20">

                <span style="grid-area: 4/1;">Dĺžka mena musí byť najmenej 3 znaky a najviac 20 znakov. Heslo musí mať minimálne 8 znakov.</span>

                <span style="grid-area: 5/1;" class="bold">E-mail:</span>
                <input name="Email" type="email" placeholder="email@.com" required class="vstup" style="grid-row: 5">

                <span style="grid-area: 6/1;" class="bold">Heslo:</span>
                <input name="Password" type="password" placeholder="Password" pattern=".{8,}" title="Heslo musí mať 8 alebo viac znakov"
                       required class="vstup" style="grid-row: 6">

                <span style="grid-area: 7/1;"  class="bold">Potvrdenie hesla:</span>
                <input name="ConfirmPassword" type="password" pattern=".{8,}" title="Heslo musí mať 8 alebo viac znakov"
                           required class="vstup" style="grid-row: 7;">

                <?php
                if(isset($_POST['UserName'])){
                    if(!$reg->porovnanieHesiel()) {
                ?>
                        <p class="all-check" style="grid-row: 7;grid-column: 2/4;">Heslá nie sú zhodné.</p>
                <?php
                    }
                    $meno = $reg->getMeno();
                    $mail = $reg->getEmail();
                    $hsl = $reg->getHeslo();
                    $select = $pripojenie->prepare("SELECT email FROM pouzivatel where email = ?");
                    $select->bind_param('s', $mail);
                    if($select->execute()){
                        $select->store_result();
                        if($select->num_rows != 0) { ?>
                            <p class="all-check" style="grid-row: 5; grid-column: 2/4">Zadaný email sa už používa.</p>
                            <?php
                        }
                    }
                    $select = $pripojenie->prepare("SELECT meno FROM pouzivatel where meno = ?");
                    $select->bind_param('s', $meno);
                    if($select->execute()) {
                        $select->store_result();
                        if($select->num_rows != 0) { ?>
                            <p class="all-check" style="grid-row: 3; grid-column: 2/4">Používateľské meno je už zabraté.</p>
                            <?php
                        } else {
                            if(strlen($meno) >= 3 && strlen($meno) <= 20 && strlen($mail) != 0 && strlen($hsl) >= 8) {
                                $hsl = password_hash($hsl, PASSWORD_BCRYPT);
                                $insert = $pripojenie->prepare("INSERT INTO pouzivatel (meno,email,heslo) VALUES (?,?,?)");
                                $insert->bind_param('sss',$meno,$mail, $hsl);
                                $insert->execute();
                                $reg->vycisti();;
                            }
                        }
                    }
                }
                ?>

                <span style="grid-area: 8/2"><input type="checkbox" required class="vstup">
                <a href="url">Suhlasím s podmienkami používania</a></span>

                <input type="submit" class="btn-reg-log" style="grid-area: 9/2">

            </div>

        </form>

        <footer class="koniec">
            ©2021 Author: Kvetoslav Varga
            <p><a href="mailto:kvetko189@gmail.com">kvetko189@gmail.com</a></p>
        </footer>

    </div>

</div>

</body>

</html>
