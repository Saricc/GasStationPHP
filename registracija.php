<!DOCTYPE html>
<html>

<head>
    <?php include('templates/head.php') ?>
    <title>Benzinska</title>
    <link rel="stylesheet" href="css/stil.css">
</head>

<body>

    <?php include('templates/header.php');
    include('templates/head.php'); ?>
    <div id="container">
        <form onsubmit=" return false;">

            <input type="text" name="ime" id="ime" placeholder="IME"><br>
            <input type="text" name="prezime" id="prezime" placeholder="PREZIME"><br>
            <input type="text" name="korisnickoime" id="korisnickoime" placeholder="KORISNICKO IME"><br>
            <input type="text" name="lozinka" id="lozinka" placeholder="LOZINKA"><br>
            <input type="text" name="email" id="email" placeholder="email"><br>
            <input type="submit" name="posalji" value="posalji" onclick="registracija()">
        </form>
        <div id="resp"></div>

        <?php
        include('templates/footer.php');
        ?>
    </div>
    <script src="js/registracija.js"></script>
</body>

</html>