<!DOCTYPE html>
<html>

<head>
    <!--google recaptcha gotova rjesenja -->
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('login_recaptcha', {
                'sitekey': '6LcxeBQkAAAAALIbwttZqh0xXP-sq_fNm6DS-9j7'
            });
        };
    </script>
    <?php include('templates/head.php'); ?>
    <link rel="stylesheet" href="css/stil.css">
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
    </script>

    <title>Benzinska</title>
</head>

<body>
    <?php include('templates/header.php'); ?>


    <div id="container">

        <form onsubmit="return false;">
            <input id="korisnickoime" type="text" name="korisnickoime" placeholder="Username-admin" />
            <input id="lozinka" type="password" name="lozinka" placeholder="Password-admin" />
            <div id="login_recaptcha"> </div>
            <input type="submit" name="posalji" value="posalji" onclick="loginAdmin()">
        </form>

    </div>
    <?php
    include('templates/footer.php');
    ?>
    <script src="js/login_admin.js"></script>
</body>

</html>