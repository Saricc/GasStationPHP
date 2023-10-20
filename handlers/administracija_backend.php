<?php
session_start();

if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    echo "niste se logirali";
    exit(0);
}
function dohvatRacuna()
{
    include('handlers/DBconnection.php');
    $query = "SELECT * FROM Racun ORDER BY datum_izdavanja DESC";
    $result = $db->query($query);
    $racuniArray = [];

    while ($row = $result->fetch_assoc()) {
        $racuniArray[] = $row;
    }
    return $racuniArray;
}
// json_encode- iz php array u json u dbconnection
function dohvatGoriva()
{
    include('handlers/DBconnection.php');
    $queryGorivo = "SELECT * FROM Gorivo";
    $resultGorivo = $db->query($queryGorivo);
    $gorivoArray = [];
    while ($row = $resultGorivo->fetch_assoc()) {
        $gorivoArray[$row['id_gorivo']] = $row;
    }
    return $gorivoArray;
}
function dohvatZaposlenika()
{
    include('handlers/DBconnection.php');
    $query = "SELECT * FROM Zaposlenik";
    $result = $db->query($query);
    $zaposlenikArray = [];
    while ($row = $result->fetch_assoc()) {
        $zaposlenikArray[$row['id_zaposlenik']] = $row;
    }
    return $zaposlenikArray;
}
$goriva = dohvatGoriva();
$racuni = dohvatRacuna();
$zaposlenici = dohvatZaposlenika();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="styleAdmin.css">
    <title>Administracija</title>
</head>

<body>
    <?php
    include('templates/header.php');
    ?>

    <h1>ADMINISTRACIJA</h1>
    <div id="container">
        <div>
            Dobrodosao/la
            <?php
            echo $zaposlenici[$_SESSION['zaposlenikID']]['ime'];
            ?>
        </div>

        <div id="dostupnoGorivo1">
            <!--dinamicni prikaz podataka koristeci ajax bez osvjezavanja stranice-->
            <div id="benzin">
                BENZIN: 0L
            </div>
            <div id="diesel">
                DIESEL: 0L
            </div>

        </div>
        <div id="div1">

            <form onsubmit='return false'>
                <select name="tip" id="tipGoriva" onchange="promjenaOdabranogGoriva()">

                    <option disabled selected>Odaberi vrstu goriva</option>
                    <?php
                    foreach ($goriva as $gorivo) {

                        echo "<option value='{$gorivo['id_gorivo']}'>{$gorivo['tip']}</option>";
                    }
                    ?>

                </select>

                <input name="kolicina" type="number" id="kolicinaGoriva" placeholder="upisite kolicinu goriva" onchange="promjenaKolicine(this)">

                <input disabled name="name" type="text" id="name" placeholder="cijena litre">
                <input disabled name="ukupnaCijena" type="number" id="ukupnaCijena" placeholder="ukupna cijena goriva">
                <button onclick="spremiRacun()">SPREMI RACUN</button>

                <div>DOSTUPNO GORIVO
                    <div id="dostupnoGorivo"></div>
                </div>
            </form>
        </div>
        <div id="div2">
            <form onsubmit='return false'>
                <select name="tip" id="tipGorivaAzuriranje">
                    <option disabled selected>Odaberi vrstu goriva</option>
                    <?php
                    foreach ($goriva as $gorivo) {
                        echo "<option value='{$gorivo['id_gorivo']}'>{$gorivo['tip']}</option>";
                    }
                    ?>
                </select>
                <input name="kolicinaGoriva" type="number" id="kolicinaGorivaAzuriranje" placeholder="upisite kolicinu goriva">
                <button onclick="azurirajGorivo()">AZUZIRAJ STANJE SPREMNIKA</button>
        </div>
    </div>
    </div>
    <div id="prikazRacuna">
        <table>
            <thead>
                <tr>
                    <th>tip goriva</th>
                    <th>kolicina</th>
                    <th>datum</th>
                    <th>ukupna cijena</th>
                    <th>zaposlenik</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($racuni as $racun) {
                    echo "<tr>";
                    echo "<td>{$goriva[$racun['tip_goriva']]['tip']}</td>";
                    echo "<td>{$racun['kolicina']}</td>";
                    echo "<td>{$racun['datum_izdavanja']}</td>";
                    echo "<td>{$racun['cijena_ukupna']}</td>";

                    echo "<td>{$zaposlenici[$racun['zaposlenik']]['ime']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        var goriva = {};

        function dohvatInformacijaOGorivima() {
            $.ajax({
                type: "POST",
                url: "handlers/gorivo_backend.php",
                data: {},
                dataType: "json",

                success: function(odgovor) {
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

                    success: function(odgovor) {
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
            document.getElementById("dostupnoGorivo").innerHTML = goriva[vrstaGoriva].trenutna_zapremnina;

            if (kolicinaGoriva && vrstaGoriva) {
                izracunajUkupnuCijenu(kolicinaGoriva, vrstaGoriva);
            }

        }

        function promjenaKolicine(event) {
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

                    success: function(odgovor) {

                        if (odgovor.uspjeh) {
                            dohvatInformacijaOGorivima();

                            alert(odgovor.uspjeh);

                        } else if (odgovor.error) {
                            alert(odgovor.error);
                        }
                    }
                });

            } else {
                alert('niste ispostovali pravila unosa')
            }
        }
    </script>

    <?php
    include('templates/footer.php');
    ?>

</body>

</html>