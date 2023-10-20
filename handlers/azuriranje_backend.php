<?php
session_start();
include('DBconnection.php');
include('toClient.php');



$kolicina = "";
$vrstaGoriva = "";

if (isset($_POST['kolicinaGoriva']) && isset($_POST['vrstaGoriva'])) {
    $kolicina = $_POST['kolicinaGoriva'];
    $vrstaGoriva = $_POST['vrstaGoriva'];

    $queryUpis = "UPDATE Gorivo SET trenutna_zapremnina= {$kolicina} WHERE id_gorivo ={$vrstaGoriva}";
    $result = $db->query($queryUpis);
    if ($result) {
        toClient(['uspjeh' => 'uspjesno azurirano gorivo']);
    } else {
        toClient(['error' => 'niste uspjesno azurirali stanje spremnika']);
    }
}
