function skusobna(nazov, poradie, tabulka) {
    document.getElementById(nazov).style.display = "none";
    document.getElementById(poradie).style.display = "none";
    if(confirm("Naozaj chcete zmazat post?")) {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "Ajaxy/odstran.php?nazov=" + nazov, true);
        xmlhttp.send();
    }
}