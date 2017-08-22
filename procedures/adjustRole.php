<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/21/17
 * Time: 3:37 PM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/bootstrap.php';
requireAdmin();

$userId = request()->get('user');
$role = request()->get('role');

switch(strtolower($role))
{
    case 'promote':
        promote($userId);
        $session->getFlashBag()->add('success', 'Promoted to Admin!');
        break;

    case 'demote':
        demote($userId);
        $session->getFlashBag()->add('success', 'Demoted from Admin!');
        break;
}

redirect('/admin.php');