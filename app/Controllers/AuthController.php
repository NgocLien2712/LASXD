<?php
namespace App\Controllers;
use App\Models\User;

class AuthController extends BaseController {
    public function showLoginForm() {
        return $this->render('auth/login');
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['nv_matkhau'])) {
            session_start();
            $_SESSION['user_id'] = $user['nv_ma'];
            $_SESSION['user_name'] = $user['nv_ten'];
            $_SESSION['user_role'] = $user['role_name'] ?? 'Khách';

            header("Location: /dashboard");
            exit;
        } else {
            header("Location: /login?error=1");
            exit;
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /login");
    }
}