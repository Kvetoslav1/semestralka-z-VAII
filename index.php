<?php
require "pripojenie.php";
require "pracovanie_s_databazou/vyberanieDatabaza.php";
session_start();

$pracovanieDatabaza = new vyberanieDatabaza();
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
                        <a href="pridatClanok.php" class="fa fa-pencil" aria-hidden="true">Vytvoriť článok</a>
                    </div>
                <?php
            }
        ?>

        <div>
            <?php
            if(isset($pripojenie)) {
                $pracovanieDatabaza->pocetKat($pripojenie);
                //prvý for na výpis kategórií
                for($i = 0; $i < $pracovanieDatabaza->getPocetKategorii(); $i++) {
                    $pracovanieDatabaza->vyberKategoriu($pripojenie, $i);
                    ?>
                    <table>
                        <tr>
                            <th><?php echo $pracovanieDatabaza->getNazovKategorie() ?></th>
                            <th>Témy</th>
                            <th>Príspevky</th>
                        </tr>
                        <?php
                        $pracovanieDatabaza->pocetClankovKategorie($pripojenie);
                        $idKategorie = $pracovanieDatabaza->getIdKategorie();
                            //vyberanie názvov článkov z databázy po jednom
                            for($j = 0; $j < $pracovanieDatabaza->getPocetClankov(); $j++) {
                                $pracovanieDatabaza->vyberClanky($pripojenie, $j);
                                ?>
                                <tr>
                                    <td> <a href="clanky.php?cl=<?php echo $pracovanieDatabaza->getNazovClanku() ?>">
                                            <?php echo $pracovanieDatabaza->getNazovClanku() ?></a>
                                        <div>
                                            <?php echo $pracovanieDatabaza->getNadpisClanku() ?>
                                        </div>
                                    </td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                            <?php } ?>
                    </table>
                    <?php
                }
            } ?>
        </div>

        <footer class="koniec">
            ©2021 Author: Kvetoslav Varga
            <p><a href="mailto:kvetko189@gmail.com">kvetko189@gmail.com</a></p>
        </footer>

    </div>

</div>

</body>

</html>