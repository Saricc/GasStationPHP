<?php
session_start();
include('DBconnection.php');
include('toClient.php');
include('postavke_backend.php');

//captcha gotova rjesenja
if (isset($_POST['captcha'])) {

    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LcxeBQkAAAAAE9XeG_yfFX1j_xkfc-iakf3RE_d&response=' . $_POST['captcha']);

    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {
        //echo 'uspjeh';
    } else {
        toClient(['captchaError' => 'Vi ste bot']);
        exit(0);
    }
} else {
    toClient(['captchaError' => 'Niste ispunili captcha']);
    exit(0);
}

$korisnickoIme = '';
$lozinka = '';
$error = '';

if (isset($_POST['korisnickoime'])) {
    $korisnickoIme = $_POST['korisnickoime'];
} else {
    $error = 'Niste upisali korisnicko ime';
}

if (isset($_POST['lozinka'])) {
    $lozinka = $_POST['lozinka'];
} else {
    $error = 'Niste upisali lozinku';
}

//provjera usernasme + uspjesna prijva odjava koristeci session
$query = "SELECT * FROM Administrator WHERE korisnickoIme = '$korisnickoIme' AND lozinka = '$lozinka'";

$rezultat = $db->query($query)->fetch_assoc();


if ($rezultat) {
    $_SESSION['adminLoggedIn'] = true;
    toClient(['uspjeh' => 'Uspjesan login']);
} else {
    toClient(['error' => 'Admin nije pronaden']);
}
