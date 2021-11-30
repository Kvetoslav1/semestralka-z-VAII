<?php
require "pripojenie.php";
session_start();
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

        <div>
            <?php
            $selectPocetKategorii = $pripojenie->prepare("SELECT count(id_kategorie) from kategorie");
            if($selectPocetKategorii->execute()) {
                $selectPocetKategorii->store_result();
                $selectPocetKategorii->bind_result($pocetKategorii);
                $selectPocetKategorii->fetch();
            }
            //prvý for na výpis kategórií
            for($i = 0; $i < $pocetKategorii; $i++) {
                $selectKategoria = $pripojenie->prepare("SELECT nazov_kategorie, id_kategorie from kategorie Limit ?,1");
                $selectKategoria->bind_param('i', $i);
                if($selectKategoria->execute()) {
                    $selectKategoria->store_result();
                    $selectKategoria->bind_result($nazovKategorie, $idKategorie);
                    $selectKategoria->fetch();
                }
                ?>
                <table>
                    <tr>
                        <th><?php echo $nazovKategorie ?></th>
                        <th>Témy</th>
                        <th>Príspevky</th>
                    </tr>
                    <?php
                $selectPocetClankov = $pripojenie->prepare("SELECT count(nazov_clanku) from clanky where id_kategorie = ?");
                $selectPocetClankov->bind_param('i', $idKategorie);
                if($selectPocetClankov->execute()) {
                    $selectPocetClankov->store_result();
                    $selectPocetClankov->bind_result($poceClankov);
                    $selectPocetClankov->fetch();
                    //vyberanie názvov článkov z databázy po jednom
                    for($j = 0; $j < $poceClankov; $j++) {
                        $selectClanky = $pripojenie->prepare("select nazov_clanku, nadpis from clanky 
                        join kategorie k on clanky.id_kategorie = k.id_kategorie where k.id_kategorie = ? limit ?,1;");
                        $selectClanky->bind_param('ii', $idKategorie, $j);
                        if($selectClanky->execute()) {
                            $selectClanky->store_result();
                            $selectClanky->bind_result($nazovClanku, $nadpisClanku);
                            $selectClanky->fetch();
                        }
                        ?>
                        <tr>
                            <td> <a href="clanky.php?cl=<?php echo $nazovClanku ?>"><?php echo $nazovClanku ?></a>
                                <div>
                                    <?php echo $nadpisClanku ?>
                                </div>
                            </td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    <?php
                    }

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