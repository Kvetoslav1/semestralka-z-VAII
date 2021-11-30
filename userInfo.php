<?php
require "pripojenie.php";
session_start();
if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="zaklad.css" rel="stylesheet" type="text/css">
    <link href="girdStyles.css" rel="stylesheet" type="text/css">
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
            <?php
            if(isset($_SESSION['Email'])) {
                $selectMeno = $pripojenie->prepare("SELECT meno FROM pouzivatel where email = ?");
                $selectMeno->bind_param('s', $_SESSION['Email']);
                if($selectMeno->execute()) {
                    $selectMeno->store_result();
                    $selectMeno->bind_result($menoPouzivatela);
                    $selectMeno->fetch();
                } ?>
                <button onclick="document.location='userInfo.php'"><i class="fa fa-user" aria-hidden="true">
                    </i><?php if(empty($menoPouzivatela)) { echo "Nepodarilo sa zistiť meno používateľa"; }
                    else {echo " $menoPouzivatela";}?></button>
                <button onclick="document.location='odhlasenie.php'"><i class="fa fa-sign-out" aria-hidden="true"></i> Odhlásenie</button>
                <?php
            } else { ?>
                <button onclick="document.location='register.php'"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrácia</button>
                <button onclick="document.location='login.php'"><i class="fa fa-sign-in" aria-hidden="true"></i> Prihlásenie</button>
            <?php }
            ?>
        </div>
        <div>
            <form method="post" enctype="application/x-www-form-urlencoded">
                <div id="userInfo" class="gridy" style="grid-row: 2/3">
                    <?php
                    $chybnaHlaska = null;
                    if(strlen($_POST['zmenaMena']) != 0){
                        if(strlen($_POST['zmenaMena']) >= 3) {
                            //kontrola ci nie je meno zabrate
                            $updateMeno = $pripojenie->prepare("SELECT meno FROM pouzivatel where meno = ?");
                            $updateMeno->bind_param('s', $_POST['zmenaMena']);
                            if($updateMeno->execute()) {
                                $updateMeno->store_result();
                                if($updateMeno->num_rows == 0) {
                                    $updateMeno->prepare("UPDATE pouzivatel SET meno = ?");
                                    $updateMeno->bind_param('s', $_POST['zmenaMena']);
                                    if($updateMeno->execute()) {
                                        header("Refresh:0");
                                        $message = "Meno bolo úspešne zmenené.";
                                        echo "<script type='text/javascript'>alert('$message');</script>";
                                    }
                                } else {
                                    $chybnaHlaska = "Meno sa už používa";
                                }
                            }
                        } else {
                            $chybnaHlaska = "Meno je príliž krátke";
                        }
                        if(strlen($chybnaHlaska) != 0) {
                            ?>
                            <span class="all-check" style="grid-row: 3; grid-column: 2/4"> <?php echo $chybnaHlaska ?></span>
                            <?php
                        }

                    }
                    if(strlen($_POST['zmenaHesla']) != 0) {
                        if(strlen($_POST['zmenaHesla']) >= 8) {
                            if(strlen($_POST['zmenaPotvrHesla']) != 0) {
                                if(strlen($_POST['zmenaPotvrHesla']) >= 8) {
                                    if($_POST['zmenaHesla'] == $_POST['zmenaPotvrHesla']) {
                                        $updateHeslo = $pripojenie->prepare("UPDATE pouzivatel set heslo = ? where email = ?");
                                        $hsl = password_hash($_POST['zmenaHesla'], PASSWORD_BCRYPT);
                                        $updateHeslo->bind_param('ss', $hsl, $_SESSION['Email']);
                                        if($updateHeslo->execute()) {
                                            $message = "Heslo bolo úspešne zmenené.";
                                            echo "<script type='text/javascript'>alert('$message');</script>";
                                        }
                                    } else {
                                        $chybnaHlaska = "Heslá sa nerovnajú";
                                    }
                                } else {
                                    $chybnaHlaska = "Potvrdzovacie heslo je krátke";
                                }
                            } else {
                                $chybnaHlaska = "Heslá sa nezhodujú";
                            }
                        } else {
                            $chybnaHlaska = "Heslo je krátke";
                        }
                        if(strlen($chybnaHlaska) != 0) {
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

            <div class="gridy" id="odstranenie-uctu" style="grid-row: 3">
                <h2 class="header" style="grid-column: 1/4;">Zmazanie účtu.</h2>
                <span id="resolution-change" style="grid-column: 1/4; grid-row: 2/3">
                        Ak naozaj chcete zmazať svoj účet tak sa spolu s ním zmažú aj všetky články, ktoré ste vytvorili
                a aj odpovede, ktoré ste napísali. Ak si naozaj prajete zmazať účet kliknite na tlačidlo ZMAZAŤ ÚČET.</span>
                <button style="grid-column: 2/3; max-width: 130px" class="btn-reg-log" onclick="potvrdenieOdstranenia()">Zmazanie účtu</button>
                <script>
                    function potvrdenieOdstranenia () {
                        if (confirm("Naozaj si prajete zamazať Váš účet?")) {
                            window.location.href = 'delete.php';
                        }
                    }
                </script>
            </div>
        </div>


        <footer class="koniec">
            ©2021 Author: Kvetoslav Varga
            <p><a href="mailto:kvetko189@gmail.com">kvetko189@gmail.com</a></p>
        </footer>

    </div>

</div>

</body>

</html>