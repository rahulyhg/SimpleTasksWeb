<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/20/17
 * Time: 10:49 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/functions.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$session = new \Symfony\Component\HttpFoundation\Session\Session();
$session->start();
