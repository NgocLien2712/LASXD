<?php
namespace App\Controllers;

class BaseController {
    // Hàm hiển thị View
    protected function render($view, $data = []) {
        extract($data); // Biến key của mảng thành biến tự do
        require_once __DIR__ . "/../../views/$view.php";
    }

    // Kiểm tra quyền (theo tài liệu 4.web-security)
    protected function checkRole($allowedRoles = []) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], $allowedRoles)) {
            header("Location: /login?error=denied");
            exit();
        }
    }
}