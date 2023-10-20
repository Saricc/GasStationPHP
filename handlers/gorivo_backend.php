<?php

include('DBconnection.php');
include('toClient.php');

$query = "SELECT * FROM Gorivo";
$result = $db->query($query);
$gorivoArray = [];

while ($row = $result->fetch_assoc()) {
    $gorivoArray[$row['id_gorivo']] = $row;
}

toClient(['gorivoPodaci' => $gorivoArray]);
