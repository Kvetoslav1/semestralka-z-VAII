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
        <form method="post" enctype="application/x-www-form-urlencoded">
            <div id="userInfo" class="gridy">
                <h2 class="header" style="grid-column: 1/4;">Údaje aktuálne prihláseného používateľa.</h2>
                <span id="resolution-change" style="grid-column: 1/4; grid-row: 2/3">
                        Vaše aktuálne údaje sú napísané v textových poliach. Ak chcete svoje údaje zmeniť tak napíšte vaše nové údaje
                do týchto polí a stlačte tlačitko na odoslanie údajov.</span>

                <span style="grid-row: 3;" class="bold">Používateľove meno:</span>
                <input name="zmenaMena" type="text" placeholder="<?php echo "pouzivatelove meno"; ?>" minlength="3" maxlength="20">
                <span style="grid-row: 4">Meno musí mať minimálne 3 znaky a maximálne 20 znakov</span>
                <span style="grid-row: 5" class="bold">Zmena hesla: </span>
                <input style="grid-row: 5" name="zmenaHesla" type="password" pattern=".{8,}" placeholder="Nové heslo">
                <span style="grid-row: 6">Ak chcete zmeniť vaše aktuálne heslo tak musíte potvrdiť nové heslo. Heslo musí mať minimálne 8 znakov</span>
                <span style="grid-row: 7" class="bold">Potvrdenie nového hesla:</span>
                <input style="grid-row: 7" name="zmenaPotvrHesla" type="password" pattern=".{8,}" placeholder="Potvrdenie nového hesla">
                <button style="grid-row: 8; grid-column: 2/3" class="btn-reg-log">Potvrdenie zmien údajov</button>
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