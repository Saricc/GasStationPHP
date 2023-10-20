<?php
session_start();
include('DBconnection.php');
include('toClient.php');


if (isset($_POST['prezime'])) {

    $query = "SELECT * FROM Zaposlenik where prezime = '{$_POST['prezime']}'";
    $result = $db->query($query);


    while ($row = $result->fetch_assoc()) {
        $pronadjen[] = $row;
    }
    if (empty($pronadjen)) {

        toClient(['error' => 'nema podataka']);
    } else {
        toClient(['uspjeh' => $pronadjen]);
    }
}


if (isset($_POST['ime'])) {

    $query = "SELECT * FROM Zaposlenik where ime = '{$_POST['ime']}'";
    $result = $db->query($query);


    while ($row = $result->fetch_assoc()) {
        $pronadjen[] = $row;
    }
    if (empty($pronadjen)) {

        toClient(['error' => 'nema podataka']);
    } else {
        toClient(['uspjeh' => $pronadjen]);
    }
}

if (isset($_POST['datum'])) {

    $query = "SELECT * FROM Racun where datum_izdavanja = '{$_POST['datum']}'";
    $result = $db->query($query)->fetch_assoc();

    if ($result) {
        toClient(['uspjeh' =>  $result]);
    } else {
        toClient(['error' => 'Nisu dobri podaci']);
    }
}
//moze bit i vise pa to popraviti
if (isset($_POST['iznos'])) {

    $query = "SELECT * FROM Racun where cijena_ukupna = '{$_POST['iznos']}'";
    $result = $db->query($query)->fetch_assoc();

    if ($result) {
        toClient(['uspjesno' =>  $result]);
    } else {
        toClient(['error' => 'Nisu dobri podaci']);
    }
}
