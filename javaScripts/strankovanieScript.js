function strankovanie(strankovanie, nazov) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("komentare").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "Ajaxy/komentareAjaxy/komentareStrankovanie.php?str="+strankovanie+"&post="+nazov, true);
    xhttp.send();

    let xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cisla").innerHTML = this.responseText;
        }
    };
    xhttp1.open("POST", "Ajaxy/komentareAjaxy/vypisCisel.php?post="+nazov+"&str="+strankovanie, true);
    xhttp1.send();
}