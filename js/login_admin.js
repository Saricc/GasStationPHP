function loginAdmin() {
    var korisnickoime = document.getElementById('korisnickoime').value;
    var lozinka = document.getElementById('lozinka').value;
    var captcha = document.getElementById('g-recaptcha-response').value;

    var data = {
        korisnickoime: korisnickoime,
        lozinka: lozinka,
        captcha: captcha
    };

    $.ajax({
        type: "POST",
        url: "handlers/loginAdmin_backend.php",
        data: data,
        dataType: "json",

        success: function (odgovor) {
            if (odgovor.uspjeh) {
                alert(odgovor.uspjeh);
                window.location = 'postavke.php';
            } else if (odgovor.error) {
                alert(odgovor.error);
            } else if (odgovor.captchaError) {
                alert(odgovor.captchaError);
            }

        }
    });
}
