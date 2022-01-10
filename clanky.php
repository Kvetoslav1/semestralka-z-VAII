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
    <link href="styles/zaklad.css" rel="stylesheet" type="text/css">
    <link href="styles/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div class="telo">

    <div class="odsadenie">

        <?php include "header.php"; ?>

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