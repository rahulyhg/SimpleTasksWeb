<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/9/17
 * Time: 4:00 PM
 */

require_once 'app/init.php';

$itemsQuery = $db->prepare("
    SELECT id, name, done
    FROM items
    WHERE user = :user
");

$itemsQuery->execute([
    'user' => $_SESSION['user_id']
]);

$items = $itemsQuery->rowCount() ? $itemsQuery : [];
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
    <link rel="icon" href="/favicon.ico">

    <title><?= $appName; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Custom styles -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/context-menu.css">

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
            <h1 class="text-center"><?= $appName; ?></h1>
        </div>

        <div class="row">
            <div class="horizontal-align">
                <?php if(!empty($items)): ?>
                    <ul class="items">
                        <?php //Set up some variables and do some work to make displaying and handling the items better.
                            foreach($items as $item):
                                //Get information about item
                                $id = $item['id'];
                                $name = $item['name'];

                                //Check if an item is done or not
                                $isDone = $item['done'];
                                $doneStatus = $isDone ? 'done' : 'undone';

                                //Create an action link for a user to do depending on the done status
                                $markMsg = $isDone ? 'mark.php?as=undone&item=' . $id : 'mark.php?as=done&item=' . $id;
                                $viewMsg = 'view.php?item=' . $id;
                                $editMsg = 'edit.php?item=' . $id; ?>
                            <li class="item" data-id="<?= $id; ?>">
                                <a class="item-<?= $doneStatus; ?>" href="<?= $viewMsg; ?>">
                                    <form action="<?= $markMsg; ?>" method="post">
                                        <div class="item-checkbox">
                                            <input id="item-checkbox-input-<?= $id; ?>"
                                                   type="checkbox"
                                                   onchange="this.form.submit()"
                                                   <?php if($isDone) echo ' checked'; ?>>
                                            <label for="item-checkbox-input-<?= $id; ?>"></label>
                                        </div>
                                    </form>

                                    <form action="<?= $editMsg; ?>" method="post">
                                        <span id="item-content-<?= $id; ?>" class="item-content"><?= $name; ?></span>
                                        <input style="display: none;" id="item-content-edit-<?= $id; ?>" class="item-content" type="text" name="content" value="<?= $name; ?>">
                                    </form>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>You haven't added any items yet!</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="horizontal-align">
                <form class="item-add" action="add.php" method="post">
                    <input class="input" name="name" placeholder="Enter a task to complete..." autocomplete="off" required>
                    <br>
                    <br>
                    <input class="submit" type="submit" value="Add">
                </form>
            </div>
        </div>
    </div>

    <?php include 'app/context-menu.php' ?>

    <script>
        //Add event for when a user wants to view an item through the context menu
        document.addEventListener("onTaskView", function()
        {
            window.location.href = "view.php?item=" + contextMenu.taskItemInContext.getAttribute("data-id");
        });

        //Add event listener for when a user wants to edit an item through the context menu
        document.addEventListener("onTaskEdit", function()
        {
            //Find the current task
            var itemText = document.getElementById("item-content-" + contextMenu.taskItemInContext.getAttribute("data-id"));
            var itemInput = document.getElementById("item-content-edit-" + contextMenu.taskItemInContext.getAttribute("data-id"));
            var oldValue = itemInput.value;

            //Turn off the item display text and turn on the input
            function toggleItemTextOff()
            {
                itemText.style.display = "none";
                itemInput.style.display = "inline-block";
            }

            //Turn off the item input and turn on the input text
            function toggleItemInputOff()
            {
                itemText.style.display = "inline-block";
                itemInput.style.display = "none";
            }

            toggleItemTextOff();

            //Remove readonly and focus on element
            itemInput.readOnly = false;
            itemInput.focus();

            //Highlight all of the text in the input
            itemInput.setSelectionRange(0, itemInput.value.length);

            //Remove readonly when focus is lost
            itemInput.addEventListener("focusout", function()
            {
                itemInput.readOnly = true;
                itemInput.value = oldValue;

                toggleItemInputOff();
            });

            //Listen for the escape key to be pressed
            window.onkeyup = function(e)
            {
                if(e.keyCode === 27) //Escape key
                {
                    itemInput.blur(); //Revert back the text to the old stuff
                    toggleItemInputOff();
                }
            };
        });

        //Add event listener for when a user wants to delete an item through the context menu
        document.addEventListener("onTaskDelete", function()
        {
            window.location.href = "delete.php?item=" + contextMenu.taskItemInContext.getAttribute("data-id");
        });
    </script>
</body>

</html>
