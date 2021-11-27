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
            <table>
                <tr>
                    <th>Všeobecné</th>
                    <th>Témy</th>
                    <th>Príspevky</th>
                </tr>
                <tr>
                    <td> <a href="url">Pravidlá</a>
                        <div>
                            Základné pravidlá komunity
                        </div>
                    </td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td> <a href="url">Oznámenia</a>
                        <div>
                            Všetky oznámenia týkajúce sa tohto fóra a novinky
                        </div>
                    </td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th>Novinky zo sveta</th>
                    <th>Témy</th>
                    <th>Príspevky</th>
                </tr>
                <tr>
                    <td> <a href="url">1. novinka</a>
                        <div>
                            Prvá nová vec
                        </div>
                    </td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td> <a href="url">2. novinka</a>
                        <div>
                            Druhá nová vec
                        </div>
                    </td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </table>
        </div>

        <footer class="koniec">
            ©2021 Author: Kvetoslav Varga
            <p><a href="mailto:kvetko189@gmail.com">kvetko189@gmail.com</a></p>
        </footer>

    </div>

</div>

</body>

</html>