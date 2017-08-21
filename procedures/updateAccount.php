<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/21/17
 * Time: 1:14 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';
requireAuth();

$currentPassword = request()->get('current_password');
$newPassword = request()->get('new_password');
$confirmPassword = request()->get('confirm_password');

//Check if new passwords match
if($newPassword != $confirmPassword)
{
    $session->getFlashBag()->add('error', 'New passwords do not match.');
    redirect('../account.php');
}

//Get the current user
$user = findUserByAccessToken();
if(empty($user))
{
    $session->getFlashBag()->add('error', 'Couldn\'t retrieve the user details. Try logging out and then log back in.');
    redirect('../account.php');
}

//Verify the password to match the one at the data base
if(!password_verify($currentPassword, $user['password']))
{
    $session->getFlashBag()->add('error', 'Current password is incorrect, please try again.');
    redirect('../account.php');
}

//Generate the updated password
$updatedPassword = updatePassword(password_hash($newPassword, PASSWORD_DEFAULT), $user['id']);

if(!$updatedPassword)
{
    $session->getFlashBag()->add('error', 'Could not update password, please try again.');
    redirect('../account.php');
}

//Give success message and redirect
$session->getFlashBag()->add('success', 'Password Updated.');
redirect('../account.php');
