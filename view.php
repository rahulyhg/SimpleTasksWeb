<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/15/17
 * Time: 7:16 PM
 */

require_once 'app/init.php';

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

    <title><?= $itemName; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Custom styles -->
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- Main content -->
    <div id="main-container" class="container">
        <div class="row">
            <h2 class="text-center"><?= $itemName; ?></h2>
        </div>
    </div>
</body>

</html>
