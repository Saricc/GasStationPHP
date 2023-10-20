function emailAdminu() {
    var poruka = document.getElementById('poruka').value;
    var email = document.getElementById('email').value;

    var data = {
        poruka: poruka,
        email: email
    }
    $.ajax({
        type: "POST",
        url: "handlers/mailAdminu_backend.php",
        data: data,
        dataType: "json",

        success: function (odgovor) {


        }
    });
}