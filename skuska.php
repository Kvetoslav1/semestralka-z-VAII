<?php
require "pripojenie.php";
require "pracovanie_s_databazou/vyberanieVkladanieDatabaza.php";
session_start();
$email = $_SESSION['Email'];
?>
<script>
    //window.onload = strankovanie(1);

    /*function strankovanie(strankovanie) {
        let xhttp = new XMLHttpRequest();
        let user = "<?php echo "$email" ?>";
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("komentare").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "Ajaxy/komentareAjaxy/komentareStrankovanie.php?str="+strankovanie+"&user="+user, true);
        xhttp.send();

        let xhttp1 = new XMLHttpRequest();
        xhttp1.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cisla").innerHTML = this.responseText;
            }
        };
        xhttp1.open("POST", "Ajaxy/komentareAjaxy/vypisCisel.php", true);
        xhttp1.send();
    }*/
</script>
<div id="komentare">

</div>

<div id="cisla">

</div>