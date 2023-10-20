<?php
include('DBconnection.php');
include('toClient.php');

$odabir = '';
$error = '';

if (isset($_POST["odabirStatistika"])) {
  $odabir = $_POST["odabirStatistika"];

  $query = "SELECT sum(cijena_ukupna) as ukupno from Racun WHERE tip_goriva= {$odabir}";

  $result = $db->query($query)->fetch_assoc();

  if ($result) {

    toClient(['uspjesno' => $result]);
  } else {
    toClient(['error' => 'Nisu dobri podaci']);
  }
} else {
  $error .= "niste odabrali tip\n";
}
