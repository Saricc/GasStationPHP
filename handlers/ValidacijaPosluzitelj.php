
<?php
include('DBconnection.php');
include('toClient.php');

$ime = "";
$prezime = "";
$lozinka = "";
$email = "";
$korisnickoIme = "";
$error = "";
//provjera je li poslan($_POST() data(isset) s klijenta na server ako je spremamo u tek kreirane varijable 
if (isset($_POST["ime"])) {
  $ime = $_POST["ime"];
} else {
  $error .= "niste upisali ime\n";
}

if (isset($_POST["prezime"])) {
  $prezime = $_POST["prezime"];
} else {
  $error .= "niste upisali prezime\n";
}
//ajax provjera username
if (isset($_POST["korisnickoIme"])) {
  $korisnickoIme = $_POST["korisnickoIme"];
  $query = "SELECT * FROM Zaposlenik WHERE korisnicko_ime='$korisnickoIme'";
  $res = $db->query($query)->fetch_assoc();
  if ($res) {
    toClient(['korisnikPostoji' => 'Korisnicko Ime vec postoji']);
    exit(0);
  }
} else {
  $error .= "niste upisali korisnickoIme\n";
}

if (isset($_POST["lozinka"])) {
  $lozinka = $_POST["lozinka"];
} else {
  $error .= "niste upisali lozinku\n";
}

if (isset($_POST["email"])) {
  $email = $_POST["email"];
} else {
  $error .= "niste upisali email\n";
}
//daljnje provjere
//email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $error .= "Invalid email format\n";
}
//username
if (strlen($korisnickoIme) < 5) {
  $error .= "korisnickoime must be at least 5 characters\n";
}
//password
if (!containsNumbers($lozinka)) {
  $error .= "lozinka must have a number\n";
}

function containsNumbers($str)
{
  return preg_match('/\d/', $str);
}
//kad budemo slali podatke, slat cemo json
//header("Content-type: application/json");

if ($error) {

  //echo json_encode(['error' => $error]);
  toClient(['error' => $error]);
  exit(0);
}

$unos = "INSERT INTO Zaposlenik(ime, prezime, korisnicko_ime, lozinka, email)
VALUES ('$ime',
'$prezime',
'$korisnickoIme',
'$lozinka',
'$email')";
$uneseno = $db->query($unos);

if ($uneseno) {
  toClient(['uspjesno' => 'success']);
} else {
  toClient(['error' => 'Nisu dobri podaci']);
}

?>





