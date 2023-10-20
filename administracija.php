<?php
session_start();
include('handlers/DBconnection.php');
include('login_provjera_token.php');
//PROVJERA HTTPS
//include('provjeraHTTPS.php');

function dohvatRacuna($db)
{
    $query = "SELECT * FROM Racun ORDER BY datum_izdavanja DESC";
    $result = $db->query($query);
    $racuniArray = [];

    while ($row = $result->fetch_assoc()) {
        $racuniArray[] = $row;
    }
    return $racuniArray;
}
// json_encode- iz php array u json u dbconnection
function dohvatGoriva($db)
{
    $queryGorivo = "SELECT * FROM Gorivo";
    $resultGorivo = $db->query($queryGorivo);
    $gorivoArray = [];
    while ($row = $resultGorivo->fetch_assoc()) {
        $gorivoArray[$row['id_gorivo']] = $row;
    }
    return $gorivoArray;
}
function dohvatZaposlenika($db)
{
    $query = "SELECT * FROM Zaposlenik";
    $result = $db->query($query);
    $zaposlenikArray = [];
    while ($row = $result->fetch_assoc()) {
        $zaposlenikArray[$row['id_zaposlenik']] = $row;
    }
    return $zaposlenikArray;
}
$goriva = dohvatGoriva($db);
$racuni = dohvatRacuna($db);
$zaposlenici = dohvatZaposlenika($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="css/stil.css">
    <title>AdministracijaZaZaposlenika</title>
</head>

<body>
    <?php
    include('templates/header.php');
    ?>

    <h1>ADMINISTRACIJA (ZA ZAPOSLENIKE)</h1>
    <div id="container">
        <div>
            *** Dobrodosao/la
            <?php
            echo $zaposlenici[$_SESSION['zaposlenikID']]['ime'];
            ?> ***
        </div>
        <br>
        <br>
        <div id="dostupnoGorivo1">
            <!--dinamicni prikaz podataka koristeci ajax bez osvjezavanja stranice-->
            Trenutna kolicina u spremnicima:
            <div id="benzin">
                BENZIN: 0L
            </div>
            <div id="diesel">
                DIESEL: 0L
            </div>
            <br>

        </div>
        <div id="div1">
            <!--   racun-->
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
                <input disabled name="cijenaLitre" type="text" id="cijenaLitre" placeholder="cijena litre">
                <input disabled name="ukupnaCijena" type="number" id="ukupnaCijena" placeholder="ukupna cijena goriva">
                <button onclick="spremiRacun()">SPREMI RACUN</button>

                <div>DOSTUPNO GORIVO
                    <div id="dostupnoGorivo"></div>
                </div>
            </form>
            <br>
        </div>
        <!--azuriranje goriva ide na backend-->
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
    <script src="js/administracija.js"></script>
    <br>
    <div>*Kliknite na poveznicu za pretragu*</div>
    <a href="pretrazivanje.php">Pretrazivanje zaposlenika i racuna</a><br>
    <br>
    <?php
    include('templates/footer.php');
    ?>

</body>

</html>