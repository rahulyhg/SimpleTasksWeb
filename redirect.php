<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/17/17
 * Time: 4:05 PM
 */

require_once 'app/init.php';

if(!isset($_GET['url']))
{
    die('No url found!');
}

header('Location: ' . $_GET['url']);