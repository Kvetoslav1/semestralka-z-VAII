<?php
require "pripojenie.php";
session_start();
if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
}
if(isset($_GET['cl'])) {
    $nazovCLanku = $_GET['cl'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="zaklad.css" rel="stylesheet" type="text/css">
    <link href="gridStyle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<script type="text/javascript">
    function limitText(textArea, aktPocet, maxPocet) {
        if (textArea.value.length > maxPocet) {
            textArea.value = textArea.value.substring(0, maxPocet);
        } else {
            aktPocet.value = maxPocet - textArea.value.length;
        }
    }
</script>

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
            <div id="pridajPost" class="gridy">
                <H2 class="header">Pridanie postu do článku <?php if (isset($nazovCLanku)) {
                        echo $nazovCLanku;
                    } ?></H2>
                <span style="padding-top: 5px; grid-column: 1" class="bold">Názov postu:</span>
                <label style="grid-row: 2; grid-column: 2">
                    <input name="post" type="text" placeholder="Názov postu" required class="vstup" maxlength="60">
                </label>

                <span style="padding-top: 5px; grid-column: 1" class="bold">Obsah článku:</span>
                <label style="grid-row: 3; grid-column: 2/4">
                    <textarea style="width: 90%; height: 100%;"
                              name="textArea" onKeyDown="limitText(this.form.textArea,this.form.countdown,100);"
                              onKeyUp="limitText(this.form.textArea,this.form.countdown,100);">
                    </textarea>
                </label>
                <div style="grid-row: 4; grid-column: 1/4">
                    <br >(Maximálny počet znakov je: 100)
                    <span>Máte ešte <input readonly type="text" name="countdown" size="1" value="100"> voľných znakov.</span><br>
                </div>
                <button class="btn-reg-log" style="grid-area: 5/2;">Vytvoriť článok</button>
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