<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/16/17
 * Time: 2:28 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';

//Retrieve the task id
$id = request()->get('item');

//Make sure there is a task
if(!isset($id))
{
    redirect('/');
}

//Delete the task
deleteTask($id);
redirect('/');
