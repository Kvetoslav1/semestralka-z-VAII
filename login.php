<?php
require "pripojenie.php";
require "pracovanie_s_databazou/praca_s_pouzivatelom/prihlasovanie.php";

session_start();
if(isset($_SESSION['Email'])) {
    header("Location: index.php");
}
$prihlasovanie = new prihlasovanie();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="styles/zakladStrankyStyle.css" rel="stylesheet" type="text/css">
    <link href="styles/gridStyle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div class="telo">

    <div class="odsadenie">

        <?php require "zakladnaStranka/header.php"; ?>

        <div class="vracenie-vytvaranie">
            <a class="fa fa-level-down" style="margin-left: 5px;" onclick="history.back()" href="#">Vrátenie späť</a>
        </div>

        <div>
            <form method="post" enctype="application/x-www-form-urlencoded">
                <div id="sing-up" class="gridy">
                    <?php
                    if(isset($_POST['UserName']) && strlen($_POST['UserName']) >= 3 && strlen($_POST['password']) >= 8 && isset($pripojenie)) {
                        if($prihlasovanie->kontrolaPrihlasenie($pripojenie, $_POST['UserName'], $_POST['password'])) {
                            $_SESSION['Email'] = $_POST['UserName'];
                            header("Location: index.php");
                        } else {
                            $hlaska = $prihlasovanie->getHlaska();
                            ?>
                            <p class="all-check" style="grid-row: 2/4;grid-column: 2/4;"><?php echo $hlaska ?></p>
                            <?php
                        }
                    }
                    ?>
                    <H2 class="header">Prihlásiť sa</H2>

                    <span style="padding-top: 5px" class="bold">Užívateľské meno:</span>
                    <input name="UserName" type="text" placeholder="Login" required class="vstup" style="grid-row: 2;">

                    <span class="bold">Heslo:</span>
                    <input name="password" type="password" placeholder="Password" required class="vstup" style="grid-row: 3;">

<!--                    <span style="grid-area: 4 / 2;align-self: center"><a href="url" class="bold">-->
<!--                    Zabudnuté heslo</a></span>-->
                    <button class="btn-reg-log" style="grid-area: 4/2;">Prihlásiť sa</button>

                </div>
            </form>

            <div id="create-acc" class="gridy">
                <h2 class="header">Vytvoriť účet</h2>
                <span class="text" style="grid-column: 1/4;">
                    Ak sa chcete prihlásiť musíte mať najprv vytvorený účet. Registrácia trvá len pár sekúnd a dáva vám
                        väčšie možnosti. Pred registráciou sa uistite, že ste sa oboznámili s podmienkami pre používanie
                        tohoto fóra a s ďalšími pravidlami na hlavnej stránke, ktoré sa môžu časom upraviť poprípade pridať.</span>
                <span style="grid-column: 1/3"> <a href="https://www.prazdroj.sk/podmienky-pouzivania">Podmienky používania</a> | <a href="https://www.websupport.sk/sukromie/">Ochrana osobných údajov</a></span>
                <button class="btn-reg-log" onclick="document.location='register.php'" style="grid-area: 4/2;">
                    Registrovať sa</button>
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