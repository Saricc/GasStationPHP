<?php
session_start();
include('DBconnection.php');
include('toClient.php');
$poruka = '';
$email = '';
$error = '';



if (isset($_POST['poruka'])) {
    $poruka = $_POST['poruka'];
}


if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

//https://www.w3schools.com/php/func_mail_mail.asp
if ($poruka && $email) {
    $text = "poruka od:{$poruka} poslano sa:{$email}";
    mail("saramunitic94@gmail.com", "poruka sa stranice", $text);
}
