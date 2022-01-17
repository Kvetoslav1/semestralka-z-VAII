function potvrdenieOdstranenia(email) {
    if(confirm("Naozaj chcete zmazať váš účet?")) {
        $.ajax({
        type: "GET",
        url: "Ajaxy/odstranenieUctu.php",
        data: {
            email
        },
        success: function () {
            window.location.href = "index.php";
        }
    });

    }
}