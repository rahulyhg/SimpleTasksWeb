<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/21/17
 * Time: 11:47 AM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';

$accessToken = new \Symfony\Component\HttpFoundation\Cookie('access_token',
    'Expired',
    time() - 3600,
    '/',
    getenv('COOKIE_DOMAIN'));
redirect("../login.php", ['cookies' => [$accessToken]]);