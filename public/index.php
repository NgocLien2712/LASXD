<?php
require_once __DIR__ . '/../vendor/autoload.php';

$router = new \Bramus\Router\Router();

// Auth Routes
$router->get('/login', '\App\Controllers\AuthController@showLoginForm');
$router->post('/login', '\App\Controllers\AuthController@login');
$router->get('/logout', '\App\Controllers\AuthController@logout');

// Employee Management (Chỉ Admin/Trưởng phòng mới được vào)
$router->get('/nhan-vien', function() {
    $controller = new \App\Controllers\UserController();
    $controller->index();
});

$router->run();