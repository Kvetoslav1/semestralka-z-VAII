    <?php
    require "pracovanie_s_databazou/praca_s_pouzivatelom/registracia.php";
    require "pripojenie.php";
    session_start();
    if(isset($_SESSION['Email'])) {
        header("Location: index.php");
    }
    if(isset($_POST['UserName'])) {
        $registracia = new registracia();
        $registracia->setParametre($_POST['UserName'], $_POST['Email'], $_POST['Password'], $_POST['ConfirmPassword']);
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

        <script src="javaScripts/registerKontrola.js"></script>
    </head>

    <body>

    <div class="telo">

        <div class="odsadenie">

            <?php require "zakladnaStranka/header.php"; ?>

            <div class="vracenie-vytvaranie">
                <a class="fa fa-level-down" style="margin-left: 5px;" onclick="history.back()" href="#">Vrátenie späť</a>
            </div>

            <form method="post" enctype="application/x-www-form-urlencoded">
                <div id="register" class="gridy">
                    <h2 class="header" style="grid-column: 1/4;">Registrácia</h2>
                    <span id="resolution-change">
                        Berte na vedomie, že musíte uviesť platnú e-mailovú adresu.
                        Táto e-mailová adresa nesmie byť zabratá a vaše príspevku budu zobrazované spolu s ňou.
                        Zároveň ju budete používať na príhlásenie do vašeho účtu.</span>

                    <span style="grid-area: 3/1; grid-row: 3" class="bold">Uživateľské meno:</span>
                    <input name="UserName" style="grid-row: 3;" type="text" placeholder="Username" required class="vstup" minlength="3" maxlength="20"
                    onkeydown="kontrolaVstupov(this.form.UserName, 20, 'meno')"
                    onkeyup="kontrolaVstupov(this.form.UserName, 20, 'meno')">

                    <span style="grid-area: 4/1;">Dĺžka mena musí byť najmenej 3 znaky a najviac 20 znakov. Heslo musí mať minimálne 8 znakov.</span>

                    <span style="grid-area: 5/1;" class="bold">E-mail:</span>
                    <input name="Email" type="email" placeholder="email@gmail.com" required class="vstup" style="grid-row: 5"
                    onkeydown="kontrolaVstupov(this.form.Email, 30, 'email')"
                    onkeyup="kontrolaVstupov(this.form.Email, 30, 'email')">

                    <span style="grid-area: 6/1;" class="bold">Heslo:</span>
                    <input id="hesloNaKontrolu" name="Password" type="password" placeholder="Password" pattern=".{8,70}" title="Heslo musí mať 8 alebo viac znakov"
                           required class="vstup" style="grid-row: 6"
                    onkeydown="kontrolaVstupov(this.form.Password, 70, 'heslo')"
                    onkeyup="kontrolaVstupov(this.form.Password, 70, 'heslo')">

                    <span style="grid-area: 7/1;"  class="bold">Potvrdenie hesla:</span>
                    <input name="ConfirmPassword" type="password" pattern=".{8,70}" title="Heslo musí mať 8 alebo viac znakov"
                           required class="vstup" style="grid-row: 7;"
                    onkeyup="kontrolaVstupov(this.form.ConfirmPassword, 70, 'potvrHeslo')"
                    onkeydown="kontrolaVstupov(this.form.ConfirmPassword, 70, 'potvrHeslo')">

                    <p id="meno" class="all-check" style="visibility: hidden; grid-row: 3; grid-column: 3">Meno nesmie obsahovať špeciálne znaky!</p>
                    <p id="email" class="all-check" style="visibility: hidden; grid-row: 5; grid-column: 3">Email musí obsahovať @ !</p>
                    <p id="heslo" class="all-check" style="visibility: hidden; grid-row: 6; grid-column: 3">Heslo musí mať minimálne 8 znakov z písmen a čísel!</p>
                    <p id="potvrHeslo" class="all-check" style="visibility: hidden; grid-row: 7;grid-column: 3;">Heslá nie sú zhodné.</p>

                    <?php
                    if(isset($_POST['UserName'],$registracia)){
                        if(isset($pripojenie)) {
                            if($registracia->zistiPouzivatelov($pripojenie, "meno", $registracia->getMeno()) != 0) { ?>
                                <p class="all-check" style="grid-row: 5; grid-column: 2/4">Zadaný email sa už používa.</p>
                                <?php
                            }
                            if($registracia->zistiPouzivatelov($pripojenie, "email", $registracia->getEmail()) != 0) { ?>
                                <p class="all-check" style="grid-row: 3; grid-column: 2/4">Používateľské meno je už zabraté.</p>
                                <?php
                            } else {
                                if(strlen($registracia->getMeno()) >= 3 && strlen($registracia->getMeno()) <= 20 && strlen($registracia->getEmail()) != 0
                                    && strlen($registracia->getHeslo()) >= 8
                                    && $registracia->porovnanieHesiel() && filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {
                                    $registracia->setHeslo(password_hash($registracia->getHeslo(), PASSWORD_BCRYPT));
                                    $sprava = $registracia->pridajPouzivatela($pripojenie);
                                    if($sprava == "Účet bol vytvorený.") {
                                        session_start();
                                        $_SESSION['Email'] = $_POST['Email'];
                                        header("Location: index.php");
                                    } else {
                                        echo "<script type='text/javascript'>alert('$sprava');</script>";
                                    }
                                }
                            }
                        }
                    }
                    ?>

                    <span style="grid-row: 8;grid-column: 2/4"><input type="checkbox" required class="vstup">
                    <a href="https://www.prazdroj.sk/podmienky-pouzivania">Suhlasím s podmienkami používania</a></span>

                    <input id="submitRegistracie" type="submit" class="btn-reg-log" style="grid-area: 9/2;">

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
