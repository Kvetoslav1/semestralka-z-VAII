function strankovanie(stranka, nazov) {
    komentare(stranka, nazov);
    strankovanieCisla(stranka, nazov);
}

function komentare(stranka, nazov) {
    $.ajax({
        type: "GET",
        url: "Ajaxy/komentareAjaxy/komentareStrankovanie.php",
        data: {
            stranka,
            nazov
        },
        success: function(data) {
            $('#komentare').html(data);
        }
    });
}

function strankovanieCisla(stranka, nazov) {
    $.ajax({
        type: "GET",
        url: "Ajaxy/komentareAjaxy/vypisCisel.php",
        data: {
            stranka,
            nazov
        },
        success: function (data) {
            $('#cisla').html(data);
        }
    });
}

function zmazanieKomentaru(cas, stranka, nazov) {
    if(confirm("Naozaj chcete zmazať odpoveď?")) {
        $.ajax({
            type: "GET",
            url: "Ajaxy/odstranOdpoved.php",
            data: {
                cas
            },
            success:function () {
                strankovanie(stranka, nazov);
            }
        });
    }
}