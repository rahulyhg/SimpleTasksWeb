<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/21/17
 * Time: 12:22 AM
 */

/** @var $task array */
$isDone = $task['done'];
$id = $task['id'];
$name = $task['name'];

$baseMarkMsg = '';
?>

<a class="<?php if($isDone) { echo 'item-done'; } ?> " href="<?= '../view.php?item=' . $id; ?>">
    <form action="<?= $isDone ? '/procedures/markTask.php?as=undone&item=' . $id : '/procedures/markTask.php?as=done&item=' . $id; ?>" method="post">
        <div class="item-checkbox">
            <input id="item-checkbox-input-<?= $id; ?>"
                   type="checkbox"
                   onchange="this.form.submit()"
                <?php if($isDone) echo ' checked'; ?>>
            <label for="item-checkbox-input-<?= $id; ?>"></label>
        </div>
    </form>

    <form action="<?= '/procedures/editTask.php?item=' . $id; ?>" method="post">
        <span id="item-name-<?= $id; ?>" class="item-name"><?= $name; ?></span>
        <input style="display: none;"
               id="item-name-edit-<?= $id; ?>"
               class="item-name"
               autocomplete="off"
               type="text"
               name="name"
               value="<?= $name; ?>">
    </form>
</a>
