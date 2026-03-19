<?php
namespace App\Controllers;
use App\Models\User;

class UserController extends BaseController {
    public function index() {
        // Lấy danh sách nhân viên từ CSDL
        $userModel = new User();
        $employees = $userModel->getAll();

        return $this->render('users/index', [
            'title' => 'Danh sách nhân viên',
            'employees' => $employees
        ]);
    }
}