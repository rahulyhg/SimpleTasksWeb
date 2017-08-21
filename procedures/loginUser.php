<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/21/17
 * Time: 4:38 AM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';

$username = request()->get('username');
$password = request()->get('password');

//Search for user by username. If not found, search by email.
$user = findUserByUsername($username);
if(empty($user))
{
    $user = findUserByEmail($username);

    if(empty($user))
    {
        $session->getFlashBag()->add('error', 'Username/Email was not found.');
        redirect('../login.php');
    }
}

//Check is the passwords match
if(!password_verify($password, $user['password']))
{
    $session->getFlashBag()->add('error', 'Password incorrect.');
    redirect('../login.php');
}

//Set an expire time
$expireTime = time() + 3600;

//Create JWT
$jwt = \Firebase\JWT\JWT::encode([
    'iss' => request()->getBaseUrl(),
    'sub' => "{$user['id']}",
    'exp' => $expireTime,
    'iat' => time(),
    'nbf' => time(),
    'is_admin' => $user['role_id'] == 1
], getenv("SECRET_KEY"), 'HS256');

//Create cookies
$accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', $jwt, $expireTime, '/', getenv('COOKIE_DOMAIN'));
$usernameCookie = new Symfony\Component\HttpFoundation\Cookie('username', $username, $expireTime, '/', getenv('COOKIE_DOMAIN'));

//Redirect with the cookie
redirect('/', ['cookies' => [$accessToken, $usernameCookie]]);
