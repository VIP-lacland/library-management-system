<?php

class AuthController {

    public function loginForm() {
        require APP_ROOT . '/app/views/auth/login.php';
    }

    public function login() {
        // Bắt đầu session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Fake user để test
        $correctEmail = "user@test.com";
        $correctPassword = "123456";

        if ($email === $correctEmail && $password === $correctPassword) {
            $_SESSION['user'] = [
                'email' => $email
            ];

            // Chuyển sang dashboard sau khi đăng nhập thành công
            header("Location: " . URL_ROOT . "/dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password";

            // Quay lại trang login
            header("Location: " . URL_ROOT . "/auth");
            exit;
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();

        header("Location: " . URL_ROOT . "/auth");
        exit;
    }

    public function forgotPassword() {
        require APP_ROOT . '/app/views/auth/forgot-password.php';
    }
}
