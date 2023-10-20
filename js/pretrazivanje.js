function metodaPretragaPrezime() {
    var prezime = document.getElementById('prezime').value;

    var data = {
        prezime: prezime
    }
    $.ajax({
        type: "POST",
        url: "handlers/pretrazivanje_backend.php",
        data: data,
        dataType: "json",

        success: function (odgovor) {
            if (odgovor.uspjeh) {
                var redovi = '';
                $.each(odgovor.uspjeh, function (key, zaposlenik) {
                    console.log(zaposlenik)
                    redovi += '<tr><td>' + zaposlenik.id_zaposlenik + '</td><td>' + zaposlenik.ime + '</td><td>' + zaposlenik.prezime + '</td><td>' + zaposlenik.korisnicko_ime + '</td><td>' + zaposlenik.lozinka + '</td><td>' + zaposlenik.email + '</td><td>' + zaposlenik.zakljucan + '</td></tr>';
                });
                $('tableRacunIznos tbody').html(redovi);
            } else if (odgovor.error) {
                alert(odgovor.error);

            }
        }
    });
}
function metodaPretragaIme() {
    var ime = document.getElementById('ime').value;

    var data = {
        ime: ime
    }
    $.ajax({
        type: "POST",
        url: "handlers/pretrazivanje_backend.php",
        data: data,
        dataType: "json",

        success: function (odgovor) {
            if (odgovor.uspjeh) {
                var redovi = '';
                $.each(odgovor.uspjeh, function (key, zaposlenik) {
                    console.log(zaposlenik);
                    redovi += '<tr><td>' + zaposlenik.id_zaposlenik + '</td><td>' + zaposlenik.ime + '</td><td>' + zaposlenik.prezime + '</td><td>' + zaposlenik.korisnicko_ime + '</td><td>' + zaposlenik.lozinka + '</td><td>' + zaposlenik.email + '</td><td>' + zaposlenik.zakljucan + '</td></tr>';
                });
                $('table tbody').html(redovi);

            } else if (odgovor.error) {
                alert(odgovor.error);

            }
        }
    });
}
function metodaPretragaDatum() {
    var datum = document.getElementById('datum').value;

    var data = {
        datum: datum
    }
    $.ajax({
        type: "POST",
        url: "handlers/pretrazivanje_backend.php",
        data: data,
        dataType: "json",
        success: function (odgovor) {
            if (odgovor.uspjeh) {

                var redovi = '';
                var racun = odgovor.uspjeh;

                redovi += '<tr><td>' + racun.id_racun + '</td><td>' + racun.datum_izdavanja + '</td><td>' + racun.tip_goriva + '</td><td>' + racun.kolicina + '</td><td>' + racun.zaposlenik + '</td><td>' + racun.cijena_ukupna + '</td></tr>';
                $('#tableRacun tbody').html(redovi);
            } else if (odgovor.error) {
                alert(odgovor.error);
            }
        }
    });
}
function metodaPretragaIznos() {
    var iznos = document.getElementById('iznos').value;
    var data = {
        iznos: iznos
    }
    $.ajax({
        type: "POST",
        url: "handlers/pretrazivanje_backend.php",
        data: data,
        dataType: "json",

        success: function (odgovor) {
            if (odgovor.uspjesno) {
                var redovi = '';
                var iznos = odgovor.uspjesno;

                redovi += '<tr><td>' + iznos.id_racun + '</td><td>' + iznos.datum_izdavanja + '</td><td>' + iznos.tip_goriva + '</td><td>' + iznos.kolicina + '</td><td>' + iznos.zaposlenik + '</td><td>' + iznos.cijena_ukupna + '</td></tr>';
                $('#tableRacunIznos tbody').html(redovi);
            } else if (odgovor.error) {
                alert(odgovor.error);
            }
        }
    });
}

