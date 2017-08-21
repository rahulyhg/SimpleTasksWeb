<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/21/17
 * Time: 2:47 AM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.png">

    <title><?= $appName; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">

    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
          crossorigin="anonymous">

    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="css/context-menu.css">
</head>

<body>
    <?php include 'inc/header.php'; ?>

    <!-- Main content -->
    <div id="main-container" class="container">
        <div class="row">
            <div class="horizontal-align">
                <form action="procedures/registerUser.php" method="post">
                    <h1 style="margin: 0; padding: 0" class="text-center">Registration</h1>
                    <input id="username-field" class="input-field light-placeholder" name="username" placeholder="Username..." autocomplete="off" required>
                    <br>
                    <input id="email-field" class="input-field light-placeholder" name="email" placeholder="Email..." autocomplete="off" required>
                    <br>
                    <input id="password-field" class="input-field light-placeholder" type="password" name="password" placeholder="Password..." autocomplete="off" required>
                    <br>
                    <input id="confirm-password-field" class="input-field light-placeholder" type="password" name="confirm_password" placeholder="Confirm Password..." autocomplete="off" required>
                    <br>
                    <input style="" class="btn submit" type="submit" value="Register">
                </form>
            </div>
        </div>
    </div>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <?php include 'inc/context-menu.php' ?>
</body>

</html>
