<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/16/17
 * Time: 12:58 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';


//Retrieve the task id and task name
$id = request()->get('item');
$name = request()->get('name');

//Make sure there is a name and a task
if(!isset($id, $name))
{
    redirect($_SERVER['HTTP_REFERER']);
}

//Trim the name to remove any un needed space at the beginning of the string
$name = trim($_POST['name'], ' ');

//Edit the task
$updatedBook = updateTask($id, $name);
redirect($_SERVER['HTTP_REFERER']);
