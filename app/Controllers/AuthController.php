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

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role_name'];
            
            header("Location: /dashboard");
        } else {
            header("Location: /login?error=1");
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /login");
    }
}