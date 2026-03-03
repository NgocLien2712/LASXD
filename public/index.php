<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Khởi tạo Router
$router = new \Bramus\Router\Router();

// Định nghĩa đường dẫn trang chủ
$router->get('/', function() {
    echo "<h1>Chào mừng bạn đến với Hệ thống LAS-XD</h1>";
});

// Định nghĩa đường dẫn Quản lý nhân viên
$router->get('/nhan-vien', function() {
    echo "Trang danh sách nhân viên";
});

$router->run();