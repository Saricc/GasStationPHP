var goriva = {};
//trenutna zapremnina prikaz dinamicki
function dohvatInformacijaOGorivima() {
    $.ajax({
        type: "POST",
        url: "handlers/gorivo_backend.php",
        data: {},
        dataType: "json",

        success: function (odgovor) {
            if (odgovor.gorivoPodaci) {
                goriva = odgovor.gorivoPodaci;
                document.getElementById("benzin").innerHTML = "BENZIN: " + goriva["1"].trenutna_zapremnina + "L";
                document.getElementById("diesel").innerHTML = "DIESEL: " + goriva["2"].trenutna_zapremnina + "L";

            }
        }
    });
}
dohvatInformacijaOGorivima();
function spremiRacun() {

    var vrstaGoriva = document.getElementById('tipGoriva').value;
    var kolicinaGoriva = document.getElementById('kolicinaGoriva').value;
    var ukupnaCijena = document.getElementById('ukupnaCijena').value;
    if (vrstaGoriva && kolicinaGoriva && ukupnaCijena) {

        if (kolicinaGoriva < 5) {
            alert('unijeli ste manje od 5 litara, nije moguce');
            return false;
        }
        if (kolicinaGoriva > parseFloat(goriva[vrstaGoriva].trenutna_zapremnina)) {
            alert('odabrali ste kolicinu vecu od dostupne')
            return false;
        }
        var data = {

            vrstaGoriva: vrstaGoriva,
            kolicinaGoriva: kolicinaGoriva,
            ukupnaCijena: ukupnaCijena
        }
        $.ajax({
            type: "POST",
            url: "handlers/racun_backend.php",
            data: data,
            dataType: "json",

            success: function (odgovor) {
                if (odgovor.uspjesno) {
                    alert(odgovor.uspjesno);
                } else if (odgovor.error) {
                    alert(odgovor.error);
                }
            }
        })
    }
}
function promjenaOdabranogGoriva() {

    var kolicinaGoriva = document.getElementById('kolicinaGoriva').value;
    var vrstaGoriva = document.getElementById('tipGoriva').value;

    document.getElementById('cijenaLitre').value = goriva[vrstaGoriva].cijena;
    //ispis dostupnog goriva onclick
    document.getElementById("dostupnoGorivo").innerHTML = goriva[vrstaGoriva].trenutna_zapremnina;
    //
    if (kolicinaGoriva && vrstaGoriva) {
        izracunajUkupnuCijenu(kolicinaGoriva, vrstaGoriva);
    }

}
//kad se promjeni upisana kolicina automatski se pomnozi koicina i cijena
function promjenaKolicine() {
    var kolicinaGoriva = document.getElementById('kolicinaGoriva').value;
    var vrstaGoriva = document.getElementById('tipGoriva').value;

    if (vrstaGoriva && kolicinaGoriva) {
        izracunajUkupnuCijenu(kolicinaGoriva, vrstaGoriva);
    }
}

function izracunajUkupnuCijenu(kolicinaGoriva, vrstaGoriva) {
    var cijena = goriva[vrstaGoriva].cijena;
    var ukupnaCijena = kolicinaGoriva * cijena;
    document.getElementById('ukupnaCijena').value = ukupnaCijena;
}
//slanje azuriranja na backend
function azurirajGorivo() {
    var kolicinaGoriva = document.getElementById('kolicinaGorivaAzuriranje').value;
    var vrstaGoriva = document.getElementById('tipGorivaAzuriranje').value;
    if (kolicinaGoriva && vrstaGoriva && kolicinaGoriva > 1000 && kolicinaGoriva < 20000) {

        var data = {
            kolicinaGoriva: kolicinaGoriva,
            vrstaGoriva: vrstaGoriva
        }

        $.ajax({
            type: "POST",
            url: "handlers/azuriranje_backend.php",
            data: data,
            dataType: "json",

            success: function (odgovor) {

                if (odgovor.uspjeh) {
                    dohvatInformacijaOGorivima();
                    alert(odgovor.uspjeh);

                }
                else if (odgovor.error) {
                    alert(odgovor.error);
                }
            }
        });

    } else {
        alert('niste ispostovali pravila unosa')
    }
}