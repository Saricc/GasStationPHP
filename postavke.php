<?php
session_start();
include('handlers/DBconnection.php');
if (!$_SESSION['adminLoggedIn']) {
    echo ('niste admin');
    exit(0);
}
function dohvatZaposlenika($db)
{
    $query = "SELECT * FROM Zaposlenik";
    $result = $db->query($query);
    $zaposlenikArray = [];
    while ($row = $result->fetch_assoc()) {
        $zaposlenikArray[$row['id_zaposlenik']] = $row;
    }
    return $zaposlenikArray;
}
$zaposlenici = dohvatZaposlenika($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="css/stil.css">
    <?php include('templates/head.php');
    ?>
</head>

<body>

    <?php
    include('templates/header.php'); ?>
    <div id="container">
        <label for="promjenaPokusaja">Promjena pokusaja</label>
        <input type="text" id="promjenaPokusaja" name="promjenaPokusaja" placeholder="Unesi broj" />
        <button onclick="promjenaPokusaja()">Spremi</button>
        <br>
        <table>
            <thead>
                <tr>
                    <th>ime</th>
                    <th>korisnicko ime</th>
                    <th>promjena</th>

                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($zaposlenici as $zaposlenik) {
                    echo "<tr>";
                    echo "<td>{$zaposlenik['ime']}</td>";
                    echo "<td>{$zaposlenik['korisnicko_ime']}</td>";


                    echo "<td>"; ?>
                    <select data-id="<?php echo $zaposlenik['id_zaposlenik']; ?>" onchange="promjenaZakljucano(this)">
                        <?php
                        if ($zaposlenik["zakljucan"] == 0) {
                            echo "<option value='0' selected>OTKLJUCANO</option>";
                            echo "<option value='1'>ZAKLJUCAN</option>";
                        } else {
                            echo "<option value='0'>OTKLJUCANO</option>";
                            echo "<option value='1' selected>ZAKLJUCAN</option>";
                        }

                        ?>
                    </select>
                <?php
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <label for="promjenaTrajanja">Promjena trajanja cookiea</label>
        <input type="text" id="promjenaTrajanja" name="promjenaTrajanja" placeholder="Unesi broj u sekundama" />
        <button onclick="promjenaTrajanja()">Spremi</button>
    </div>

    <?php
    include('templates/footer.php');
    ?>
    <script src="js/postavke.js"></script>
</body>

</html>