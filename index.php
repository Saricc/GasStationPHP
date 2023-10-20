<?php
session_start();
include('handlers/DBconnection.php');
//PROVJERA HTTPS
//include('provjeraHTTPS.php');

//OGRANICEN PREGLED PODATAKA ZA NEREGISTRIRANOG KORISNIKA/-redci
function dohvatRacuna($db)
{
    $query = "SELECT * FROM Racun ORDER BY datum_izdavanja DESC LIMIT 0,2";
    $result = $db->query($query);
    $racuniArray = [];

    while ($row = $result->fetch_assoc()) {
        $racuniArray[] = $row;
    }
    return $racuniArray;
}
$racuni = dohvatRacuna($db);
?>

<!DOCTYPE html>

<head>
    <?php include('templates/head.php');
    ?>
    <!--cookie plugin library-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
    <link rel="stylesheet" href="css/stil.css">
    <title>GasStationHomepage</title>
</head>

<body>
    <?php
    include('templates/header.php');
    ?>
    <?php
    if ($_SESSION['loggedIn'] && $_COOKIE['token']) {
        echo 'Korisnik je logiran <button onclick="logout()">Logout</button><br>';
        echo '<a href="administracija.php">Administracija</a><br>';
        echo '<a href="pretrazivanje.php">Pretrazivanje</a><br>';
        echo '<a href="statistika.php">Statistika</a><br>';
    } else {
        echo '<a href="login.php">LOGIN</a><br>';
        echo '<a href="registracija.php">REGISTRACIJA</a><br>';
        echo '<a href="login_admin.php">LOGIN ADMIN</a><br>';
    }
    ?>
    <div id="container">
        <div id="uvjeti">
            Prihvacan uvjete koristenja
            <button onclick="prihvacam()">Prihvacam</button>
        </div>

        <div id="ogranicenPregled">OGRANICEN PREGLED PODATAKA ZA NEREGISTRIRANOG KORISNIKA </div>

        <table>
            <thead>
                <tr>
                    <!--ograniceni stupci za neregistriranog-->
                    <th>tip goriva</th>
                    <th>kolicina</th>
                    <th>datum</th>
                    <th>ukupna cijena</th>

                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($racuni as $racun) {
                    echo "<tr>";
                    echo "<td>{$racun['tip_goriva']}</td>";
                    echo "<td>{$racun['kolicina']}</td>";
                    echo "<td>{$racun['datum_izdavanja']}</td>";
                    echo "<td>{$racun['cijena_ukupna']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    include('templates/footer.php');
    ?>
    <script src="js/index.js"></script>
</body>

</html>