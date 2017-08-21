<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/16/17
 * Time: 2:28 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

if(!isset($_GET['item']))
{
    die('No item found!');
}

$itemsQuery = $db->prepare("
    DELETE FROM items
    WHERE id = :id
    AND user = :user
");

$itemsQuery->execute([
    'id' => $_GET['item'],
    'user' => $_SESSION['user_id']
]);

header('Location: ' . '../index.php');