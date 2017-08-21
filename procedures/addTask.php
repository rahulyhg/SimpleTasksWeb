<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/9/17
 * Time: 4:21 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';

//Retrieve the name of the task
$name = request()->get('name');

//Make sure there is a name
if(!isset($name))
{
    redirect('/');
}

//Trim the name to remove any un needed space at the beginning of the string
$name = trim($_POST['name'], ' ');

//Add the new task
$newTask = addTask($name);
redirect('/');
