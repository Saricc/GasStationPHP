<?php
session_start();
include('DBconnection.php');
include('toClient.php');


$kolicina = "";
$ukupnaCijena = "";
$vrstaGoriva = "";
$error = "";
$zaposlenikID = "";



if (isset($_POST["kolicinaGoriva"])) {
    $kolicina = $_POST["kolicinaGoriva"];
} else {
    $error .= "niste upisali kolicinu\n";
}

if (isset($_POST["ukupnaCijena"])) {
    $ukupnaCijena = $_POST["ukupnaCijena"];
} else {
    $error .= "niste upisali ukupnu cijenu\n";
}

if (isset($_POST["vrstaGoriva"])) {
    $vrstaGoriva = $_POST["vrstaGoriva"];
} else {
    $error .= "niste upisali vrstu goriva\n";
}


if (isset($_SESSION['zaposlenikID'])) {
    $zaposlenikID = $_SESSION['zaposlenikID'];
} else {
    $error .= 'nije zadan ID zaposlenika';
}

if (!empty($error)) {
    toClient(['error' => $error]);
    exit(0);
}
$datum = date("Y-m-d H:i:s");

$query = "INSERT INTO Racun(datum_izdavanja, tip_goriva, kolicina,zaposlenik,cijena_ukupna) VALUES
('$datum','$vrstaGoriva','$kolicina','$zaposlenikID','$ukupnaCijena')";

$uneseno = $db->query($query);


if ($uneseno) {
    toClient(['uspjeh' => 'uspjesno uneseni podaci']);
} else {
    toClient(['error' => 'nisu dobro uneseni podaci']);
}
