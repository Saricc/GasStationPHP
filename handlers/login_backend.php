<?php
session_start();
include('DBconnection.php');
include('toClient.php');
include('postavke_backend.php');
//https://www.geeksforgeeks.org/generating-random-string-using-php/ (pamcenje korisnika)
function getName($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}
$brojDozvoljenihPokusaja = dozvoljenBrojLogina();
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
//zakljucavaje racuna radi broja pokusaja
if (isset($_SESSION['failedLogin']) && $_SESSION['failedLogin'] == $brojDozvoljenihPokusaja) {



    toClient(['prekoraceno' => 'Prekoracili ste dozvoljen broj unosa']);
    exit(0);
}
//provjera korisnicko ime
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
$query = "SELECT * FROM Zaposlenik WHERE korisnicko_ime='$korisnickoIme' AND lozinka='$lozinka' AND zakljucan=0";
$rezultat = $db->query($query)->fetch_assoc();




if ($rezultat) {

    $queryCookieTime = "SELECT  trajanje_cookiea FROM Postavke WHERE id_postavke = 1";
    $cookietime = $db->query($queryCookieTime)->fetch_assoc();

    $_SESSION["loggedIn"] = true;

    $_SESSION["zaposlenikID"] = $rezultat['id_zaposlenik'];

    $token =  getName(10);

    setcookie('token', $token, time() + $cookietime['trajanje_cookiea'], '/');

    $query = "UPDATE Zaposlenik SET token=  '$token' where id_zaposlenik = {$rezultat['id_zaposlenik']}";

    $result = $db->query($query);

    //kod uspjesnog logina izbrisi prijasnje neuspjele loginove
    unset($_SESSION['failedLogin']);
    toClient(['uspjeh' => 'Uspjesan login']);
} else {
    toClient(['error' => 'Korisnik nije pronaden ili je zakljucan']);
    if (isset($_SESSION['failedLogin'])) {
        //ako postoji varijabla failed login u sessionu povecaj ga za 1
        $_SESSION['failedLogin']++;
    } else {
        //ako je prvi neuspjesni login stvori tu varijablu u sessionu
        $_SESSION['failedLogin'] = 1;
    }
}
