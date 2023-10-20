<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!--google recaptcha gotova rjesenja -->
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('login_recaptcha', {
                'sitekey': '6LcxeBQkAAAAALIbwttZqh0xXP-sq_fNm6DS-9j7'
            });
        };
    </script>
    <link rel="stylesheet" href="css/stil.css">
    <?php include('templates/head.php'); ?>
    <title>Benzinska</title>
</head>

<body>

    <?php
    include('templates/header.php');
    ?>

    <div id="container">
        <form onsubmit="return false;">
            <input id="korisnickoime" type="text" name="korisnickoime" placeholder="Korisnicko ime" />
            <input id="lozinka" type="password" name="lozinka" placeholder="Lozinka" />
            <div id="login_recaptcha"> </div>
            <input type="submit" name="posalji" value="posalji" onclick="login()">


        </form>
    </div>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
    </script>
    <?php
    include('templates/footer.php');
    ?>
    <script src="js/login.js"></script>
</body>



</html>