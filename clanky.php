<?php
require "pripojenie.php";
require "pracovanie_s_databazou/vyberanieVkladanieDatabaza.php";
session_start();
$nazovClanku = "";
if(isset($_GET['cl'])) {
    $nazovClanku = $_GET['cl'];
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
    <script src="javaScripts/mazanieClanku.js"></script>
</head>

<body>

<div class="telo">

    <div class="odsadenie">

        <?php require "zakladnaStranka/header.php";  ?>

        <div class="vracenie-vytvaranie">
            <div>
                <a class="fa fa-level-down" aria-hidden="true" style="margin-left: 5px;" href="index.php" ">Vrátenie na hlavnú stránku</a>
            </div>
        <?php
        if(isset($_SESSION['Email'])) {
            ?>
            <div style="text-align: end;grid-column: 2">
                <a href="pridatPost.php?cl=<?php echo $nazovClanku ?>" class="fa fa-pencil" aria-hidden="true">Vytvoriť post do článku</a>
            </div>
            <?php
        }
        ?>
        </div>
        <div>
            <?php
            if(isset($pripojenie)) {
                $vyberanie = new vyberanieVkladanieDatabaza();
                $pocet = $vyberanie->dajPocetPostov($pripojenie, $nazovClanku);
                $email = "";
                ?>
                <table>
                    <tr>
                        <th><?php echo $nazovClanku ?></th>
                        <th>Príspevky</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < $pocet; $i++) {
                        $vyberanie->vypisPost($pripojenie, $nazovClanku, $i);
                        $email = $vyberanie->getEmailVytvarajucehoPostu();
                        ?>
                        <tr>
                            <td id="<?php echo $vyberanie->getNadpisPostu() ?>">
                                <div style="display: grid;grid-template-columns: [first] 70% [second] 30%;grid-template-rows: [row1-start] auto [row2-start] auto;">
                                    <div>
                                        <a href="posty.php?post=<?php echo $vyberanie->getNadpisPostu() ?>&cl=<?php echo $nazovClanku ?>">
                                            <?php echo $vyberanie->getNadpisPostu() ?></a>
                                    </div>

                                    <?php
                                    if($email == $_SESSION['Email']) {
                                        ?>
                                        <div style="text-align: right">
                                            <a href="upravaPostu.php?np=<?php echo $vyberanie->getNadpisPostu()?>&cl=<?php echo $nazovClanku ?>"
                                               style="font-size: medium;text-align: right" class="fa fa-pencil" aria-hidden="true">Upravenie postu</a>
                                        </div>
                                        <div style="text-align: right">
                                            <a onclick="odstranenie('<?php echo $vyberanie->getNadpisPostu() ?>','<?php echo $i ?>')" href="#" style="font-size: medium; text-align: right" class="fa fa-times" aria-hidden="true"> Zmazanie postu</a>
                                        </div>

                                        <?php
                                    }
                                    ?>
                                    <div style="grid-column: 1; grid-row: 2">
                                        <?php echo "Tento post vytvoril používateľ $email"; ?>
                                    </div>
                                </div>
                            </td>
                            <td id="<?php echo $i ?>">0</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </div>

        <footer class="koniec">
            ©2021 Author: Kvetoslav Varga
            <p><a href="mailto:kvetko189@gmail.com">kvetko189@gmail.com</a></p>
        </footer>

    </div>

</div>

</body>

</html>