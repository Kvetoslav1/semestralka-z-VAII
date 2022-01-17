<?php
require "pripojenie.php";
require "pracovanie_s_databazou/vyberanieVkladanieDatabaza.php";

session_start();
if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
}

$vyberanie = new vyberanieVkladanieDatabaza();
$nazovPostu = "";
$nazovClanku = "";
if (isset($_GET['post'],$_GET['cl'])) {
    $nazovPostu = $_GET['post'];
    $nazovClanku = $_GET['cl'];
}
if(isset($_POST['odpoved'], $pripojenie)) {
    if(!$vyberanie->pridajOdpoved($pripojenie, $_POST['odpoved'], $nazovPostu, $_SESSION['Email'])) {
        ?>
        <script>alert("Odpoveď nebola pridaná!")</script>
        <?php
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="styles/zakladStrankyStyle.css" rel="stylesheet" type="text/css">
    <link href="styles/tableStyles.css" rel="stylesheet" type="text/css">
    <link href="styles/gridStyle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script src="javaScripts/strankovanieScript.js"></script>
</head>

<script>
    strankovanie(1, '<?php echo $nazovPostu ?>');
</script>

<body id="postyBody">

<div class="telo" style="grid-template-rows: [row1-start] 0.6% [row2-start] 98.8% [row3-start] 0.6%;">

    <div class="odsadenie">

        <?php require "zakladnaStranka/header.php"; ?>

        <div class="vracenie-vytvaranie">
            <div>
                <a class="fa fa-level-down" aria-hidden="true" style="margin-left: 5px;" href="clanky.php?cl=<?php echo $nazovClanku ?>">Vrátenie na článok <?php echo $nazovClanku ?></a>
            </div>
        </div>

        <div id="gridPosty" class="gridy">
            <h2 class="header"><?php echo $nazovPostu ?></h2>
            <textarea class="post-area" readonly disabled style="grid-column: 2/3">
                <?php if(isset($pripojenie)) echo $vyberanie->dajTextPostu($pripojenie, $nazovPostu); ?></textarea>
            <h2 class="header" style="grid-row: 3;">Odpovede:</h2>

            <div id="komentare" style="grid-row: 4; grid-column: 2/3">

            </div>
            <div id="cisla" style="grid-row: 5; grid-column: 2/3; text-align: center;">

            </div>
            <div style="grid-row: 6; grid-column: 1/4">
                <h2 class="header">Pridať odpoveď</h2>
                <form method="post" enctype="application/x-www-form-urlencoded">
                    <textarea id="odpovedTextArea" name="odpoved" maxlength="500"></textarea>
                    <input style="margin-left: 45%" type="submit" class="btn-reg-log">
                </form>
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