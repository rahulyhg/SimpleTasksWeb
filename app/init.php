<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/9/17
 * Time: 11:08 PM
 */

session_start();

$_SESSION['user_id'] = 1;

$db = new PDO('mysql:dbname=todo_list;host=localhost', 'root', '');
$appName = "SimpleTasks";

//Handle this on another way
if(!isset($_SESSION['user_id']))
{
    die('You are not signed in.');
}