<!DOCTYPE html>
<html>

<head>
    <title>Pretrazivanje</title>
    <?php
    include('templates/header.php');
    include('templates/head.php');
    ?>
    <link rel="stylesheet" href="css/stil.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


</head>

<body>
    <div id="container">
        <div id="odabir">
            <br>
            * ODABERITE STO ZELITE PRETRAZITI *<br>
            <br>
            1) Pretraga zaposlenika po imenu i prezimenu<br> <br>

            <form onsubmit="return false">
                <input type="text" id="ime" name="ime" placeholder="IME">
                <input type="submit" name="submit" onclick="metodaPretragaIme()">
            </form>

            <form onsubmit="return false">
                <input type="text" id="prezime" name="prezime" placeholder="PREZIME">
                <input type="submit" name="submit" onclick="metodaPretragaPrezime()">
            </form>
            <table id="tablicaIme">
                <thead>
                    <tr>
                        <th>ime</th>
                        <th>prezime</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div id="racun">

            <br>
            2) Pretraga racuna po datumu i iznosu<br>
        </div>
        <select name="datum" id="datum" onchange="metodaPretragaDatum()">
            <option disabled selected>Odaberi datum</option>
            <?php
            include('handlers/DBconnection.php');
            $query = "SELECT * FROM Racun";
            $datumi = $db->query($query);

            while ($datum = $datumi->fetch_assoc()) {
                echo "<option value='{$datum['datum_izdavanja']}'>{$datum['datum_izdavanja']}</option>";
            }
            ?>
        </select>
        <br>


        <table id="tableRacun">
            <thead>
                <tr>
                    <th>id racuna</th>
                    <th>datum</th>
                    <th>tip goriva</th>
                    <th>kolicina</th>
                    <th>zaposlenik</th>
                    <th>ukupna cijena</th>

                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>


        <div id="odabir">
            <form onsubmit="return false">
                <input type="text" id="iznos" name="iznos" placeholder="iznos">
                <input type="submit" name="submit" onclick="metodaPretragaIznos()">
            </form>

            <table id="tableRacunIznos">
                <thead>
                    <tr>
                        <th>id racuna</th>
                        <th>datum</th>
                        <th>tip goriva</th>
                        <th>kolicina</th>
                        <th>zaposlenik</th>
                        <th>ukupna cijena</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <?php
        include('templates/footer.php');
        ?>
        <script src="js/pretrazivanje.js"></script>
</body>

</html>