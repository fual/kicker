<?php
require __DIR__ . '/../inc/bootstrap.php';
requireAdmin();

$userId = request()->get('userId');

deleteUser($userId);
$session->getFlashBag()->add('success', 'User Deleted!');

redirect('/admin.php');