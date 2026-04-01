<?php
// 1. Nạp các thư viện từ Composer
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

// 2. Sử dụng các Namespace
use Bramus\Router\Router;

// 3. Khởi tạo Router
$router = new Router();

// 4. Định nghĩa các đường dẫn (Routes)
$router->get('/', function () {
    if (isset($_SESSION['user_id'])) {
        header('Location: /dashboard');
        exit;
    }
    echo "<h1>Hệ thống Quản lý LAS-XD đã sẵn sàng!</h1>";
    echo "<a href='/login'>Đi tới trang Đăng nhập</a>";
});

// Route đăng nhập / đăng xuất
$router->get('/login', '\App\Controllers\AuthController@showLoginForm');
$router->post('/login', '\App\Controllers\AuthController@login');
$router->get('/logout', '\App\Controllers\AuthController@logout');

// Dashboard
$router->get('/dashboard', '\App\Controllers\DashboardController@index');

// ==========================================
// QUẢN LÝ DỰ ÁN
// ==========================================
$router->get('/du-an', '\App\Controllers\DuAnController@index');
$router->post('/du-an/luu', '\App\Controllers\DuAnController@store');
$router->get('/du-an/sua', '\App\Controllers\DuAnController@edit');
$router->post('/du-an/cap-nhat', '\App\Controllers\DuAnController@update');
$router->get('/du-an/xoa', '\App\Controllers\DuAnController@delete');

// ==========================================
// QUẢN LÝ ĐƠN VỊ
// ==========================================
$router->get('/don-vi', '\App\Controllers\DonViController@index');
$router->post('/don-vi/luu', '\App\Controllers\DonViController@store');
$router->get('/don-vi/sua', '\App\Controllers\DonViController@edit');
$router->post('/don-vi/cap-nhat', '\App\Controllers\DonViController@update');
$router->get('/don-vi/xoa', '\App\Controllers\DonViController@delete');

// ==========================================
// QUẢN LÝ NHÂN VIÊN
// ==========================================
$router->get('/nhan-vien', '\App\Controllers\NhanVienController@index');
$router->get('/nhan-vien/tao-moi', '\App\Controllers\NhanVienController@create');
$router->post('/nhan-vien/luu', '\App\Controllers\NhanVienController@store');
$router->get('/nhan-vien/sua', '\App\Controllers\NhanVienController@edit');
$router->post('/nhan-vien/cap-nhat', '\App\Controllers\NhanVienController@update');
$router->get('/nhan-vien/xoa', '\App\Controllers\NhanVienController@delete');

// ==========================================
// QUẢN LÝ PHIẾU YÊU CẦU & THÍ NGHIỆM
// ==========================================
$router->get('/phieu-yeu-cau', '\App\Controllers\PhieuYeuCauController@index');
$router->get('/phieu-yeu-cau/tao-moi', '\App\Controllers\PhieuYeuCauController@create');
$router->post('/phieu-yeu-cau/luu', '\App\Controllers\PhieuYeuCauController@store');
$router->get('/phieu-yeu-cau/xem', '\App\Controllers\PhieuYeuCauController@show');
$router->post('/phieu-yeu-cau/luu-mau', '\App\Controllers\PhieuYeuCauController@luuMau');
$router->post('/phieu-yeu-cau/luu-phep-thu', '\App\Controllers\PhieuYeuCauController@luuPhepThu');

$router->get('/phep-thu/sua', '\App\Controllers\PhepThuController@edit');
$router->post('/phep-thu/cap-nhat', '\App\Controllers\PhepThuController@update');
$router->get('/phep-thu/xoa', '\App\Controllers\PhepThuController@delete');
$router->get('/ajax/phep-thu', '\App\Controllers\PhieuYeuCauController@getPhepThuAjax');
$router->get('/ajax/chung-loai', '\App\Controllers\PhieuYeuCauController@getChungLoaiAjax');
$router->get('/phieu-yeu-cau/xoa-mau', '\App\Controllers\PhieuYeuCauController@xoaMau');
$router->post('/phieu-yeu-cau/cap-nhat-mau', '\App\Controllers\PhieuYeuCauController@capNhatMau');
$router->get('/phieu-yeu-cau/in', '\App\Controllers\PhieuYeuCauController@inPhieu');
$router->get('/phieu-yeu-cau/in-phieu-tho', 'App\Controllers\PhieuYeuCauController@inPhieuTho');

// Quản lý cấu hình vật liệu và phép thử
$router->get('/cau-hinh', '\App\Controllers\CauHinhController@index');
$router->post('/cau-hinh/save', '\App\Controllers\CauHinhController@save');
$router->get('/cau-hinh/delete-test', '\App\Controllers\CauHinhController@deleteTest');

// Quản lý danh mục
$router->get('/danh-muc', 'App\Controllers\DanhMucController@index');
$router->post('/danh-muc/nhom/save', 'App\Controllers\DanhMucController@saveNhom');
$router->post('/danh-muc/vat-lieu/save', 'App\Controllers\DanhMucController@saveVatLieu');

$router->get('/danh-muc/nhom/delete', 'App\Controllers\DanhMucController@deleteNhom');
$router->get('/danh-muc/vat-lieu/delete', 'App\Controllers\DanhMucController@deleteVatLieu');
$router->post('/danh-muc/nhom/update', 'App\Controllers\DanhMucController@updateNhom');
$router->post('/danh-muc/vat-lieu/update', 'App\Controllers\DanhMucController@updateVatLieu');

// 5. Chạy Router
$router->run();