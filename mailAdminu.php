<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Benzinska</title>
    <link rel="stylesheet" href="stil.css">
</head>

<body>
    <?php
    include('templates/head.php');
    include('templates/header.php');
    ?>

    <div id="container">
        <form onsubmit="return false;">
            <input id="poruka" type="textarea" name="poruka" placeholder="Upisite svoju poruku ovdje" />
            <input id="email" type="textbox" name="email" placeholder="Upisite svoj mail ovdje" />

            <input type="submit" name="posalji" value="posalji" onclick="emailAdminu()">
        </form>
    </div>

    <?php
    include('templates/footer.php');
    ?> <script src="js/mailAdminu.js"> </script>
</body>

</html>