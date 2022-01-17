<?php
require "pripojenie.php";
require "pracovanie_s_databazou/vyberanieVkladanieDatabaza.php";
session_start();

$pracovanieDatabaza = new vyberanieVkladanieDatabaza();
if(isset($_POST['nazovPostu'], $pripojenie)) {
    if(!$pracovanieDatabaza->pridajKategoriu($pripojenie, $_POST['nazovPostu'])) {
        ?>
        <script>
            alert("Kategória nebola pridaná!");
        </script>
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
</head>

<body>

<div class="telo">

    <div class="odsadenie">

        <?php require "zakladnaStranka/header.php"; ?>

        <?php
            if(isset($_SESSION['Email']) && isset($pripojenie)) {
                ?>
                    <div class="vracenie-vytvaranie">
                        <?php
                        if($pracovanieDatabaza->isAdmin($pripojenie, $_SESSION['Email'])) {
                            ?>
                            <form method="post" enctype="application/x-www-form-urlencoded" style="align-self: start">
                                <span class="bold">Názov kategórie:</span>
                                <input name="nazovPostu" type="text" maxlength="40">
                                <button type="submit" class="btn-reg-log">Vytvoriť</button>
                            </form>
                            <?php
                        }
                        ?>
                        <a href="pridatClanok.php" class="fa fa-pencil" aria-hidden="true" style="grid-column: 2">Vytvoriť článok</a>
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
                                    <td><?php echo $pracovanieDatabaza->dajPocetPostovClanku($pripojenie); ?></td>
                                    <td><?php echo $pracovanieDatabaza->dajPocetOdpovediClanku($pripojenie); ?></td>
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