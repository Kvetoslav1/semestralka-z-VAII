<?php
require "pripojenie.php";
session_start();
if(isset($_SESSION['Email'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="zaklad.css" rel="stylesheet" type="text/css">
    <link href="girdStyles.css" rel="stylesheet" type="text/css">
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
            <button onclick="document.location='register.php'"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrácia</button>
            <button onclick="document.location='login.php'"><i class="fa fa-sign-in" aria-hidden="true"></i> Prihlásenie</button>
        </div>

        <div>
            <form method="post" enctype="application/x-www-form-urlencoded">
                <div id="sing-up" class="gridy">
                    <?php
                    if(isset($_POST['UserName'])) {
                        if(strlen($_POST['UserName']) >= 3 && strlen($_POST['password']) >= 8) {
                            $select = $pripojenie->prepare("SELECT meno, heslo, email FROM pouzivatel where meno = ?");
                            $select->bind_param('s', $_POST['UserName']);
                            if($select->execute()) {
                                $select->store_result();
                                $select->bind_result($meno, $heslo, $email);
                                $select->fetch();
                                if($select->num_rows == 1) {
                                    if(password_verify($_POST['password'],$heslo)) {
                                        $_SESSION['Email'] = $email;
                                        header("Location: index.php");
                                    } else {
                                        $hlaskaHeslo = "Nesprávne zadané heslo.";
                                    }
                                } else {
                                    $hlaskaMeno = "Nesprávne zadané meno";
                                }
                            }
                        } else {
                            $hlaskaMeno = "Meno alebo heslo nie sú správne";
                        }
                    }
                    if(strlen($hlaskaHeslo) != 0) {
                        ?>
                        <p class="all-check" style="grid-row: 2/4;grid-column: 2/4;"><?php echo $hlaskaHeslo ?></p>
                        <?php
                    }
                    if(strlen($hlaskaMeno) != 0) {
                        ?>
                        <p class="all-check" style="grid-row: 2/4;grid-column: 2/4;"><?php echo $hlaskaMeno ?></p>
                        <?php
                    }
                    ?>
                    <H2 class="header">Prihlásiť sa</H2>

                    <span style="padding-top: 5px" class="bold">Užívateľské meno:</span>
                    <input name="UserName" type="text" placeholder="Login" required class="vstup" style="grid-row: 2;">

                    <span class="bold">Heslo:</span>
                    <input name="password" type="password" placeholder="Password" required class="vstup" style="grid-row: 3;">

                    <span style="grid-area: 4 / 2;align-self: center"><a href="url" class="bold">
                    Zabudnuté heslo</a></span>
                    <button class="btn-reg-log" style="grid-area: 5/2;">Prihlásiť sa</button>

                </div>
            </form>

            <div id="create-acc" class="gridy">
                <h2 class="header">Vytvoriť účet</h2>
                <span class="text" style="grid-column: 1/4;">
                    Ak sa chcete prihlásiť musíte mať najprv vytvorený účet. Registrácia trvá len pár sekúnd a dáva vám
                        väčšie možnosti. Pred registráciou sa uistite, že ste sa oboznámili s podmienkami pre používanie
                        tohoto fóra a s ďalšími pravidlami na hlavnej stránke, ktoré sa môžu časom upraviť poprípade pridať.</span>
                <span style="grid-column: 1/3"> <a href="url">Podmienky používania</a> | <a href="url">Ochrana súkromia</a></span>
                <button class="btn-reg-log" onclick="document.location='register.php'" style="grid-area: 4/2;">
                    Registrovať sa</button>
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