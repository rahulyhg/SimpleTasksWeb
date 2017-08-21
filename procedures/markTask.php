<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/11/17
 * Time: 4:06 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';

//Retrieve the task done status and task id
$as = request()->get('as');
$id = request()->get('item');

//Make sure there is a done status and a task
if(!isset($as, $id))
{
    redirect($_SERVER['HTTP_REFERER']);
}

//Mark the task
markTask($id, $as);
redirect($_SERVER['HTTP_REFERER']);
