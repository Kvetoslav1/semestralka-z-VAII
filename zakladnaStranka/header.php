<div>
    <img src="../images/space1.jpg" class="slideShow" alt="Image not found">
    <img src="../images/space2.jpg" class="slideShow" alt="Image not found">
    <img src="../images/space3.jpg" class="slideShow" alt="Image not found">
    <script src="../javaScripts/slideShowScript.js"></script>
</div>

<div class="btn-group">
    <button onclick="document.location='index.php'">Články/Podpora</button>
    <button onclick="document.location='info.php'">Info</button>
    <?php
    if(isset($_SESSION['Email'])) {
        if(isset($pripojenie)) {
            $selectMeno = $pripojenie->prepare("SELECT meno FROM pouzivatel where email = ?");
            $selectMeno->bind_param('s', $_SESSION['Email']);
            if($selectMeno->execute()) {
                $selectMeno->store_result();
                $selectMeno->bind_result($menoPouzivatela);
                $selectMeno->fetch();
            }
        }
        ?>
        <button onclick="document.location='userInfo.php'"><i class="fa fa-user" aria-hidden="true">
            </i><?php if(empty($menoPouzivatela)) { echo "user"; }
            else {echo " $menoPouzivatela";}?></button>

        <button onclick="document.location='odhlasenie.php'"><i class="fa fa-sign-out" aria-hidden="true"></i> Odhlásenie</button>

        <?php
    } else { ?>
        <button onclick="document.location='register.php'"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrácia</button>
        <button onclick="document.location='login.php'"><i class="fa fa-sign-in" aria-hidden="true"></i> Prihlásenie</button>
    <?php }
    ?>
</div>