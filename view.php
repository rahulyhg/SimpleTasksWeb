<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/15/17
 * Time: 7:16 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';

/*
if(!isset($_GET['item']))
{
    die('No item found!');
}

$itemsQuery = $db->prepare("
    SELECT id, name, done
    FROM items
    WHERE id = :id
    AND user = :user
");

$itemsQuery->execute([
    'id' => $_GET['item'],
    'user' => $_SESSION['user_id']
]);

$items = $itemsQuery->rowCount() ? $itemsQuery : [];
*/

$task = getTask(request()->get('item'));

/*
//Since we are should only be dealing with one item, we can get the item's information up here to prevent any other loops except for the one right here
$itemId = 0;
$itemName = "";
$itemDone = false;
foreach($items as $item)
{
    $itemId = $item['id'];
    $itemName = $item['name'];
    $itemDone = $item['done'];
    break; //Break on the first item since we should only be dealing with one item anyways
}
*/

//Create links for different actions
$markMsg = $task['done'] ? '/procedures/markTask.php?as=undone&item=' . $task['id'] : '/procedures/markTask.php?as=done&item=' . $task['id'];
$editMsg = '/procedures/editTask.php?item=' . $task['id'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.png">

    <title><?= $task['name']; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/view.css">
    <link rel="stylesheet" type="text/css" href="css/context-menu.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php include 'inc/header.php'; ?>

    <!-- Main content -->
    <div id="main-container" class="container">
        <div class="row">
            <div class="horizontal-align">
                <form action="<?= $editMsg; ?>" method="post" name="editOnPageForm">
                    <label id="item-name-label" for="item-name" class="item-name <?php if($task['done']) { echo 'line-through'; } ?>" contenteditable><?= $task['name']; ?></label>
                    <input id="item-name" class="item-name" type="hidden" name="name" value="<?= $itemName; ?>">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="horizontal-align">
                <a class="btn submit text-center" href="/"><i class="fa fa-arrow-left text-success"></i> Go Back</a>
            </div>
        </div>

        <div class="row">
            <div class="horizontal-align">
                <form action="<?= $markMsg; ?>" method="post">
                    <button class="btn submit" type="submit">
                        <i class="fa fa-check <?php if($task['done']) { echo 'text-danger'; } else { echo 'text-success'; } ?>"></i>
                        Mark as <?php if($task['done']) { echo 'Incomplete'; } else { echo 'Complete'; } ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="horizontal-align">
                <button class="btn submit" onclick="submit(document.getElementById('item-name'), document.getElementById('item-name-label'))">
                    <i class="fa fa-edit text-success"></i>
                    Save
                </button>
            </div>
        </div>

        <div class="row">
            <div class="horizontal-align">
                <a class="btn submit text-center" href="procedures/deleteTask.php?item=<?= $task['id']; ?>"><i class="fa fa-times text-danger"></i> Delete</a>
            </div>
        </div>
    </div>

    <script src="js/view.js"></script>

    <?php include 'inc/context-menu.php' ?>
</body>

</html>
