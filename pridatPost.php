<?php
require "pripojenie.php";
require "pracovanie_s_databazou/clanky_posty/pridavaniePostu.php";

session_start();
if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
}
if(!isset($_GET['cl'])) {
    header("Location: index.php");
}
$nazovCLanku = "";
if(isset($_GET['cl'])) {
    $nazovCLanku = $_GET['cl'];
    if(isset($_POST['post']) && strlen($_POST['textArea']) > 50 && isset($pripojenie)) {
        $pridavanie = new pridavaniePostu();
        if(!$pridavanie->pridajPost($pripojenie, $nazovCLanku, $_SESSION['Email'], $_POST['textArea'], $_POST['post'])) {
            $hlaska = "Článok nebol pridaný!";
        } else {
            header("Location: index.php");
        }
    }
}
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

        <?php require "zakladnaStranka/header.php"; ?>

        <div class="vracenie-vytvaranie">
            <div>
                <a class="fa fa-level-down" aria-hidden="true" style="margin-left: 5px;" href="clanky.php?cl=<?php echo $nazovCLanku ?>">Vrátenie na článok <?php echo $nazovCLanku ?></a>
            </div>
        </div>

        <form method="post" enctype="application/x-www-form-urlencoded" style="grid-row: 4">
            <div id="pridajPost" class="gridy">
                <H2 class="header">Pridanie postu do článku: <?php if (isset($nazovCLanku)) {
                        echo $nazovCLanku;
                    } ?></H2>
                <span style="padding-top: 5px; grid-column: 1" class="bold">Názov postu:</span>
                <label style="grid-row: 2; grid-column: 2">
                    <input name="post" type="text" placeholder="Názov postu" required class="vstup" maxlength="60">
                </label>

                <span style="padding-top: 5px; grid-column: 1" class="bold">Obsah článku:</span>
                <label style="grid-row: 3; grid-column: 2/4">
                    <textarea name="textArea" onKeyDown="limitText(this.form.textArea,this.form.countdown,1000);"
                    onKeyUp="limitText(this.form.textArea,this.form.countdown,1000);" style="width: 90%; height: 100%; resize: none" minlength="50" maxlength="1000"></textarea>
                </label>
                <div style="grid-row: 4; grid-column: 1/4">
                    <br >(Maximálny počet znakov je: 1000)
                    <span>Máte ešte <input readonly type="text" name="countdown" size="1" value="1000"> voľných znakov.</span><br>
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