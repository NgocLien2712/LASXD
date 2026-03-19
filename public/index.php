<?php
// 1. Nạp các thư viện từ Composer
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

// 2. Sử dụng các Namespace
use Bramus\Router\Router;
use App\Controllers\AuthController;

// 3. Khởi tạo Router
$router = new Router();

// 4. Định nghĩa các đường dẫn (Routes)
$router->get('/', function () {
    // Nếu đã đăng nhập, chuyển thẳng đến dashboard
    if (isset($_SESSION['user_id'])) {
        header('Location: /dashboard');
        exit;
    }

    echo "<h1>Hệ thống Quản lý LAS-XD đã sẵn sàng!</h1>";
    echo "<a href='/login'>Đi tới trang Đăng nhập</a>";
});

// Route đăng nhập (Dùng cú pháp Class@Method)
$router->get('/login', '\App\Controllers\AuthController@showLoginForm');
$router->post('/login', '\App\Controllers\AuthController@login');



// Route logout
$router->get('/logout', '\App\Controllers\AuthController@logout');

// Dashboard
$router->get('/dashboard', '\App\Controllers\DashboardController@index');

// Quản lý Dự án
$router->get('/du-an', '\App\Controllers\DuAnController@index');
// Route hiển thị Form thêm mới
$router->get('/du-an/tao-moi', '\App\Controllers\DuAnController@create');
// Route xử lý dữ liệu khi người dùng bấm nút Lưu (dùng POST)
$router->post('/du-an/luu', '\App\Controllers\DuAnController@store');
// Route hiển thị Form sửa (nhận ID trên thanh địa chỉ)
$router->get('/du-an/sua', '\App\Controllers\DuAnController@edit');
// Route xử lý lưu dữ liệu sau khi sửa xong
$router->post('/du-an/cap-nhat', '\App\Controllers\DuAnController@update');
// Route xử lý Xóa dự án (nhận ID trên thanh địa chỉ)
$router->get('/du-an/xoa', '\App\Controllers\DuAnController@delete');

// Quản lý Nhân viên
$router->get('/nhan-vien', '\App\Controllers\NhanVienController@index');
$router->get('/nhan-vien/tao-moi', '\App\Controllers\NhanVienController@create');
$router->post('/nhan-vien/luu', '\App\Controllers\NhanVienController@store');
$router->get('/nhan-vien/sua', '\App\Controllers\NhanVienController@edit');
$router->post('/nhan-vien/cap-nhat', '\App\Controllers\NhanVienController@update');
$router->get('/nhan-vien/xoa', '\App\Controllers\NhanVienController@delete');

// Quản lý Đối tác
$router->get('/doi-tac', '\App\Controllers\DoiTacController@index');
$router->get('/doi-tac/tao-moi', '\App\Controllers\DoiTacController@create');
$router->post('/doi-tac/luu', '\App\Controllers\DoiTacController@store');
$router->get('/doi-tac/sua', '\App\Controllers\DoiTacController@edit');
$router->post('/doi-tac/cap-nhat', '\App\Controllers\DoiTacController@update');
$router->get('/doi-tac/xoa', '\App\Controllers\DoiTacController@delete');

// 5. Chạy Router
$router->run();
