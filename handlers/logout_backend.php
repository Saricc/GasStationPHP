<?php
session_start();
include("toClient.php");

unset($_SESSION['loggedIn']);
unset($_SESSION['zaposlenikID']);
unset($_COOKIE['korisnickoIme']);

toClient(['uspjesno' => 'Korisnik je uspjesno odlogiran']);
