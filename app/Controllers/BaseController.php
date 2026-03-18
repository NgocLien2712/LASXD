<?php
namespace App\Controllers;

class BaseController {
    protected function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../../views/$view.php";
    }

    
    protected function checkAuth($allowedRoles = []) {
    // Tạm thời comment (vô hiệu hóa) các dòng kiểm tra
    /*
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit();
    }
    */
    return true; // Luôn cho qua
}
}