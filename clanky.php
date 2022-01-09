<?php
require "pripojenie.php";
session_start();
if(isset($_GET['cl'])) {
    $nazovClanku = $_GET['cl'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="zaklad.css" rel="stylesheet" type="text/css">
    <link href="style.css" rel="stylesheet" type="text/css">
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

        <?php
        if(isset($_SESSION['Email'])) {
            ?>
            <div style="background-color: #b7c7c9; text-align: end;border-radius: 5px;">
                <a href="pridatPost.php?cl=<?php echo $nazovClanku ?>" class="fa fa-pencil" aria-hidden="true">Vytvoriť post do článku</a>
            </div>
            <?php
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