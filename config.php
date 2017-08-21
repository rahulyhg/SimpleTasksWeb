<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/9/17
 * Time: 11:08 PM
 */

session_start();

$_SESSION['user_id'] = 1;

$db = new PDO('mysql:dbname=id2640085_simpletasksweb;host=localhost', 'id2640085_mrstank', '?LBev5B3aAV62j!Q^fg!');
$appName = "SimpleTasks";

//Handle this on another way
if(!isset($_SESSION['user_id']))
{
    die('You are not signed in.');
}