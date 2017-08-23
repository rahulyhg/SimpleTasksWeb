<?php
/**
 * Author: KyleStank
 * Date: 8/21/17
 * Time: 4:03 AM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';

$email = request()->get('email');
$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');

//Make sure passwords are the same
if($password != $confirmPassword)
{
    $session->getFlashBag()->add('error', 'Passwords do not match.');
    redirect('../register.php');
}

//Check if user already exists with the same email
$user = findUserByEmail($email);
if(!empty($user))
{
    $session->getFlashBag()->add('error', 'Email taken.');
    redirect('../register.php');
}

//Generate a hashed version of the password
$hashed = password_hash($password, PASSWORD_DEFAULT);

//Create the user
$user = createUser($email, $hashed);

/** Log in the user automatically */
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

//Create access token
$accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', $jwt, $expireTime, '/', getenv('COOKIE_DOMAIN'));

//Redirect with the cookie
redirect('/', ['cookies' => [$accessToken]]);
