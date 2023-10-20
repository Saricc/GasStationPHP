<?php

if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    echo "niste se logirali";
    echo "<a href='index.php'>LOGIN</a>";
    exit(0);
} else {
    if (isset($_COOKIE['token']) && isset($_SESSION['zaposlenikID'])) {
        $query = "SELECT token FROM Zaposlenik where token = '{$_COOKIE['token']}' AND id_zaposlenik= '{$_SESSION['zaposlenikID']}'";

        $result = $db->query($query);
        if (!$result) {
            echo "nismo pronasli token";
            exit(0);
        }
    } else {
        echo "Istekla vam je sesija";
        exit(0);
    }
}
