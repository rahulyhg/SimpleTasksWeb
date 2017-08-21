<?php
/**
 * Author: KyleStank
 * Date: 8/21/17
 * Time: 4:03 AM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';

$username = request()->get('username');
$email = request()->get('email');
$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');

//Make sure passwords are the same
if($password != $confirmPassword)
{
    //redirect('../register.php');
    die("Passwords do not match!");
}

//Check if user already exists with the same username
$user = findUserByUsername($username);
if(!empty($user))
{
    //redirect('../register.php');
    die("Username taken!");
}

//Check if user already exists with the same email
$user = findUserByEmail($email);
if(!empty($user))
{
    //redirect('../register.php');
    die("Email taken!");
}

//Generate a hashed version of the password
$hashed = password_hash($password, PASSWORD_DEFAULT);

//Create the user
$user = createUser($username, $email, $hashed);

redirect('/');
