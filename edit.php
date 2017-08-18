<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/16/17
 * Time: 12:58 PM
 */

require_once 'app/init.php';

if(!isset($_GET['item']))
{
    die('No item found!');
}

if(!isset($_POST['name']))
{
    die('No item name found!');
}

$name = trim($_POST['name'], ' ');
var_dump($name);

if(empty($name))
{
    die("Name was empty!");
}

$itemsQuery = $db->prepare("
    UPDATE items
    SET name = :name
    WHERE id = :id
    AND user = :user
");

$itemsQuery->execute([
    'name' => $name,
    'id' => $_GET['item'],
    'user' => $_SESSION['user_id']
]);

header('Location: ' . $_SERVER['HTTP_REFERER']);
