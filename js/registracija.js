function registracija() {

    const name = document.getElementById('ime').value;
    const surname = document.getElementById('prezime').value;
    const username = document.getElementById('korisnickoime').value;
    const password = document.getElementById('lozinka').value;
    const eemail = document.getElementById('email').value;

    let alerts = "";

    if (name === '' || surname === '' || username === '' || password === '' || eemail === '') {
        alerts += "Nisu unesene sve vrijednosti\n";
        //    alert ("nije upisano ");
        //    return;
    }

    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (!eemail.match(mailformat)) {
        alerts += "Email nije valjan\n";
        // alert("email nije valjan!");
        // return;
    };

    if (username.length < 5) {
        alerts += "korisnicko ime je krace od 5 znakova\n";
        // alert("lozinka sadrzi minimalno 5 znakova ");
    }

    if (!/\d/.test(password)) {
        alerts += "lozinka mora sadrzavati bar jedan broj\n";
    }
    if (alerts !== "") {
        alert(alerts);
        return;
    }
    const data = {
        ime: name,
        prezime: surname,
        korisnickoIme: username,
        lozinka: password,
        email: eemail
    };
    sendToPhp(data);
}

function sendToPhp(data) {

    $.ajax({
        type: "POST",
        url: "handlers/ValidacijaPosluzitelj.php",
        data: data,
        dataType: "json",
        success: function (odgovor) {
            if (odgovor.uspjesno) {
                alert(odgovor.uspjesno);
                window.location = 'login.php';

            } else if (odgovor.error) {
                alert(odgovor.error);
            } else if (odgovor.korisnikPostoji) {
                alert(odgovor.korisnikPostoji);
            };
        }
    })

}