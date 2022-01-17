<?php
require "pripojenie.php";
require "pracovanie_s_databazou/clanky_posty/pridavaniePostu.php";
require "pracovanie_s_databazou/vyberanieVkladanieDatabaza.php";

session_start();
if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
}
$nazovClanku = "";
$nazovPostu = "";
$textPostu = "";
if(isset($_GET['cl'], $_GET['np']) && isset($pripojenie)) {
    $vyberanie = new vyberanieVkladanieDatabaza();
    $nazovClanku = $_GET['cl'];
    $nazovPostu = $_GET['np'];
    $textPostu = $vyberanie->dajTextPostu($pripojenie, $nazovPostu);
    if(isset($_POST['post']) && strlen($_POST['textArea']) > 50) {
        $update = new pridavaniePostu();
        if(!$update->updatePost($pripojenie, $nazovPostu, $_POST['post'], $_POST['textArea'])) {
        echo "<script type='text/javascript'>alert('Článok nebol upravený!');</script>";
        } else {
            header("Location: clanky.php?cl=".$nazovClanku);
        }
    }
} else {
    header("Location:  clanky.php?cl=".$nazovClanku);
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

        <div class="gridy" style="grid-template-columns: [first] 50% [second] 50%; grid-template-rows: [row1-start] 15px; border-radius: 10px;
            ;grid-gap: 0; margin-top: 0">
            <div>
                <a class="fa fa-level-down" aria-hidden="true" style="margin-left: 5px;" href="clanky.php?cl=<?php echo $nazovClanku ?>">Vrátenie na článok <?php echo $nazovClanku ?></a>
            </div>
        </div>

        <form method="post" enctype="application/x-www-form-urlencoded">
            <div id="pridajPost" class="gridy">
                <H2 class="header">Upravenie postu: <?php if (isset($nazovPostu)) {
                        echo $nazovPostu;
                    } ?></H2>
                <span style="padding-top: 5px; grid-column: 1" class="bold">Názov postu:</span>
                <label style="grid-row: 2; grid-column: 2">
                    <input name="post" type="text" value="<?php echo $nazovPostu ?>" required class="vstup" maxlength="60">
                </label>

                <span style="padding-top: 5px; grid-column: 1" class="bold">Obsah článku:</span>
                <label style="grid-row: 3; grid-column: 2/4">
                    <textarea style="width: 90%; height: 100%;"
                              name="textArea" onKeyDown="limitText(this.form.textArea,this.form.countdown,1000);"
                              onKeyUp="limitText(this.form.textArea,this.form.countdown,1000);">
                        <?php echo $textPostu ?>
                    </textarea>
                </label>
                <div style="grid-row: 4; grid-column: 1/4">
                    <br >(Maximálny počet znakov je: 1000)
                    <span>Máte ešte <input readonly type="text" name="countdown" size="1" value="1000"> voľných znakov.</span><br>
                </div>
                <button class="btn-reg-log" style="grid-area: 5/2;">Upraviť článok</button>
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