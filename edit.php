<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/16/17
 * Time: 12:58 PM
 */

require_once 'app/init.php';

if(!isset($_GET['item'], $_POST['content']))
{
    die('No item found!');
}

$content = trim($_POST['content']);

if(empty($content))
{
    return;
}

$itemsQuery = $db->prepare("
    UPDATE items
    SET name = :content
    WHERE id = :id
    AND user = :user
");

$itemsQuery->execute([
    'content' => $content,
    'id' => $_GET['item'],
    'user' => $_SESSION['user_id']
]);

header('Location: index.php');
