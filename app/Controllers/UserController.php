<?php
namespace App\Controllers;
use App\Models\User;

class UserController extends BaseController {
    public function index() {
    // Thay vì gọi Model lấy từ DB, ta tự tạo mảng dữ liệu giả
    $employees = [
        ['nv_ma' => 1, 'nv_tendn' => 'admin', 'nv_ten' => 'Nguyễn Văn A', 'nv_sdt' => '0123', 'cv_ten' => 'Admin'],
        ['nv_ma' => 2, 'nv_tendn' => 'nv01', 'nv_ten' => 'Trần Thị B', 'nv_sdt' => '0987', 'cv_ten' => 'Kỹ thuật viên'],
    ];

    return $this->render('users/index', [
        'title' => 'Xem trước Giao diện',
        'employees' => $employees
    ]);
}
    }