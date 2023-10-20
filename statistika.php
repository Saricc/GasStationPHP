<?php
include('handlers/DBconnection.php');
$queryBenzin = "SELECT sum(cijena_ukupna) as ukupnoBenzin from Racun WHERE tip_goriva= 1";
$queryDiesel = "SELECT sum(cijena_ukupna) as ukupnoDiesel from Racun WHERE tip_goriva= 2";
$resultBenzin = $db->query($queryBenzin)->fetch_assoc();
$resultDiesel = $db->query($queryDiesel)->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/stil.css">
    <script src="https://cdn.plot.ly/plotly-2.18.0.min.js"></script>
    <?php
    include('templates/head.php');
    ?>
</head>

<body>
    <?php include('templates/header.php'); ?>
    <div> STATISTIKA => POVIJEST TOCENOG GORIVA</div><br>
    <div>ODABERI VRSTU GORIVA</div><br>
    <form onsubmit='return false'>
        <select name="tip" id="tip" onchange="izlistStatistike()">

            <option disabled selected>Odaberi vrstu goriva</option>
            <?php
            $query = "SELECT * FROM Gorivo";
            $result = $db->query($query);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_gorivo']}'>{$row['tip']}</option>";
            }
            ?>
        </select>

    </form>
    <table id="tableUkupanIznos">
        <thead>
            <tr>
                <th>iznos ukupne prodaje</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="statistikaGoriva"></div>


    <?php
    include('templates/footer.php');
    ?>
    <script>
        function izlistStatistike() {
            var odabirStatistika = document.getElementById('tip').value;

            var data = {
                odabirStatistika: odabirStatistika
            }
            $.ajax({
                type: "POST",
                url: "handlers/statistika_backend.php",
                data: data,
                dataType: "json",

                success: function(odgovor) {
                    if (odgovor.uspjesno) {
                        console.log(odgovor.uspjesno);
                        var zbroj = odgovor.uspjesno;
                        var redovi = '';
                        redovi += '<tr><td>' + zbroj.ukupno + '</td></tr>';
                        $('#tableUkupanIznos tbody').html(redovi);
                    }
                }
            });
        }

        var data = [{
            values: [<?php echo $resultBenzin['ukupnoBenzin']; ?>, <?php echo $resultDiesel['ukupnoDiesel']; ?>],
            labels: ['Benzin', 'Diesel'],
            type: 'pie'
        }];

        var layout = {
            height: 400,
            width: 500
        };

        Plotly.newPlot('statistikaGoriva', data, layout);
    </script>

</body>

</html>