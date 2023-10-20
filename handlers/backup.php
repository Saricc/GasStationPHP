<?php
//kod uzet od profesora iz primjera i popravljen
include('DBconnection.php');
// varijabla za pohranu backup koda
$backupSQL = "";

// dohvat svih tablica iz baze podataka
$query = "SHOW TABLES";
$rezultat = $db->query($query);
$tablice = [];

while ($row = $rezultat->fetch_array()) {
    $tablice[] = $row[0];
}

// dohvat podataka iz tablice
foreach ($tablice as $tablica) {
    // dohvat koda za kreiranje tablice
    $sql = "SHOW CREATE TABLE " . $tablica;
    $createTableSQL = $db->query($sql)->fetch_assoc()['Create Table'] ?? ''; //vrati prazan string ako nema nista ??
    $backupSQL .= $createTableSQL . ";\n\n";

    // dohvat podataka iz tablice
    $sql = "SELECT * FROM " . $tablica;
    $result = $db->query($sql);
    $backupSQL .= "INSERT INTO " . $tablica . " VALUES ";
    $dataArray = [];
    while ($row = $result->fetch_array()) {
        $dataArray[] = "('" . implode('\',\'', $row) . "')";
    }
    $backupSQL .= implode(',', $dataArray) . ";\n\n\n";
}


// spremanje sadržaja varijable $backupSQL u datoteku dbBackup_....sql.
if (!empty($backupSQL)) {
    $backupFile = "dbBackup_" . date('Y-m-d_H-i-s') . "_.sql";
    $file = fopen($backupFile, "w+");
    fwrite($file, $backupSQL);
    fclose($file);

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backupFile));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backupFile));
    ob_clean();
    flush();
    readfile($backupFile);
    exec('rm ' . $backupFile);
}
