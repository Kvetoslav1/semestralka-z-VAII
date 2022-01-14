<?php
require "pripojenie.php";
require "pracovanie_s_databazou/vyberanieDatabaza.php";
session_start();
$email = $_SESSION['Email'];
?>
<script>
    window.onload = strankovanie(1);

    function strankovanie(strankovanie) {
        var xhttp = new XMLHttpRequest();
        let user = "<?php echo "$email" ?>";
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("komentare").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "Ajaxy/komentare/komentareStrankovanie.php?str="+strankovanie+"&user="+user, true);
        xhttp.send();
    }

        function prvotneVypisanie() {
        var xhttp = new XMLHttpRequest();
        let user = "<?php echo "$email" ?>";
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("komentare").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "Ajaxy/komentare/prveKomentare.php?user="+user, true);
        xhttp.send();
    }
</script>
<div id="komentare">

</div>

<div>
    <?php
    $dajPocetOdpovedi = new vyberanieDatabaza();
    if(isset($pripojenie)) {
        $pocet = $dajPocetOdpovedi->dajPocetKomentarovPostu($pripojenie, 'sdf sa fs');
        $modulo = $pocet % 4;
        $pocet /= 4;
        if($modulo != 0) {
            $pocet = floor($pocet);
            $pocet +=1;
        }
        for ($i = 1; $i <= $pocet; $i++) {
            ?>
            <a onclick="strankovanie(<?php echo $i ?>)" href="#"><?php echo $i ?></a>
            <?php
        }
    }
    ?>
</div>