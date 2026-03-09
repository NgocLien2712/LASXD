<?php
// 1. Nạp các thư viện từ Composer
require_once __DIR__ . '/../vendor/autoload.php';

// 2. Sử dụng các Namespace
use Bramus\Router\Router;
use App\Controllers\AuthController;

// 3. Khởi tạo Router
$router = new Router();

// 4. Định nghĩa các đường dẫn (Routes)
$router->get('/', function() {
    echo "<h1>Hệ thống Quản lý LAS-XD đã sẵn sàng!</h1>";
    echo "<a href='/login'>Đi tới trang Đăng nhập</a>";
});

// Route đăng nhập (Dùng cú pháp Class@Method)
$router->get('/login', '\App\Controllers\AuthController@showLoginForm');
$router->post('/login', '\App\Controllers\AuthController@login');

// Route logout
$router->get('/logout', '\App\Controllers\AuthController@logout');

// 5. Chạy Router
$router->run();