<?php

class AuthController {

    public function loginForm() {
        require APP_ROOT . '/app/views/auth/login.php';

    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Fake user để test
        $correctEmail = "user@test.com";
        $correctPassword = "123456";

        if ($email === $correctEmail && $password === $correctPassword) {
            $_SESSION['user'] = $email;
            header("Location: " . URL_ROOT . "/dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header("Location: " . URL_ROOT . "/auth");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: " . URL_ROOT . "/auth");
        exit;
    }

    public function forgotPassword() {
    require APP_ROOT . '/app/views/auth/forgot-password.php';
}


}
