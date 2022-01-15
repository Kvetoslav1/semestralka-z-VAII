function odstranenie(nazov, poradie) {
    if(confirm("Naozaj chcete zmazat post?")) {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "Ajaxy/odstranClanok.php?nazov=" + nazov, true);
        xmlhttp.send();

        document.getElementById(nazov).style.display = "none";
        document.getElementById(poradie).style.display = "none";
    }
}