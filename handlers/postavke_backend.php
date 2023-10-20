<?php

if (isset($_POST['metoda']) && $_POST['metoda'] == 'promjenaDozvoljenogBrojaLogina') {
    if (isset($_POST['broj'])) {
        setDozvoljenBrojLogina($_POST['broj']);
    } else {
        toClient(['error' => 'Niste unjeli broj promjena']);
        exit(0);
    }
} else if (isset($_POST['metoda']) && $_POST['metoda'] == 'promjenaZakljucano') {
    promjenaZakljucano();
} else if (isset($_POST['metoda']) && $_POST['metoda'] == 'promjenaTrajanja') {
    promjenaTrajanja();
}
function promjenaZakljucano()
{
    include('DBconnection.php');
    if (isset($_POST['id']) && isset($_POST['zakljucano'])) {
        $query = "UPDATE Zaposlenik SET zakljucan = '{$_POST['zakljucano']}' WHERE id_zaposlenik = '{$_POST['id']}'";
        $result = $db->query($query);
    }
}

function dozvoljenBrojLogina()
{
    include('DBconnection.php');
    $query = 'SELECT broj_dozv_pokusaja FROM Postavke';
    $result = $db->query($query)->fetch_assoc();
    return $result['broj_dozv_pokusaja'];
}
function setDozvoljenBrojLogina($broj)
{   //zasto zeza
    include('toClient.php');
    include('DBconnection.php');
    $query = 'UPDATE Postavke SET broj_dozv_pokusaja = ' . $broj . ' WHERE id_postavke =1';
    $result = $db->query($query);
    if ($result) {
        toClient(['uspjesno' => 'Uspjesno promjenjen broj pokusaja']);
    } else {
        toClient(['error' => 'Neuspjesno mjenjanje broja pokusaja']);
    }
}


function promjenaTrajanja()
{
    include('DBconnection.php');
    if (isset($_POST['broj'])) {
        $query = "UPDATE Postavke SET trajanje_cookiea = '{$_POST['broj']}' WHERE id_postavke = 1";
        $result = $db->query($query);
    }
}
