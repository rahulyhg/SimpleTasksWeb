<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/9/17
 * Time: 4:00 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';

$tasks = [];

if(isAuthenticated())
{
    $tasks = getAllTasks();
}
else
{
    $session->getFlashBag()->add('error', 'Please log in to see your tasks.');
}
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
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/context-menu.css">
</head>

<body>
    <?php include 'inc/header.php'; ?>

    <!-- Main content -->
    <div id="main-container" class="container">
        <div class="row">
            <div class="horizontal-align">
                <?= displayErrors(); ?>
            </div>

            <div class="horizontal-align">
                <?php if(empty($tasks) && isAuthenticated()): ?>
                    <p>You haven't added any items yet!</p>
                <?php else: ?>
                    <ul class="items">
                        <?php foreach($tasks as $task): ?>
                            <li class="item" data-id="<?= $task['id'] ?>">
                                <?php include 'inc/task.php'; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <?php if(isAuthenticated()): ?>
            <div class="row">
                <div class="horizontal-align">
                    <form class="item-add" action="procedures/addTask.php" method="post">
                        <input class="input-field" name="name" placeholder="Enter a task to complete..." autocomplete="off" required>
                        <br>
                        <input class="btn submit" type="submit" value="Add">
                    </form>
                </div>
            </div>
        <?php endif; ?>
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
