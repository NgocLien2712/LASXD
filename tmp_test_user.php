<?php
require __DIR__ . '/vendor/autoload.php';
use App\Models\User;

$userModel = new User();
$user = $userModel->findByUsername('admin');
var_dump($user);
