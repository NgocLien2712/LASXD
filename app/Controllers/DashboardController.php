<?php
namespace App\Controllers;

class DashboardController extends BaseController {
    public function index() {
        $this->checkAuth(); // Chỉ ai đăng nhập mới được xem dashboard
        
        $data = [
            'title' => 'Bảng điều khiển LAS-XD',
            'user_name' => $_SESSION['user_name'],
            'user_role' => $_SESSION['user_role']
        ];
        
        return $this->render('dashboard/index', $data);
    }
}