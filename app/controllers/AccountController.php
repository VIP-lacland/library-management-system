<?php

class AccountController extends Controller
{
    public function register()
    {
        // nếu đăng nhập sẽ, chuyển về trang chủ
        if (isset($_SESSION['user_id'])) {
            $this->redirect(url('index.php?action=index'));
        }
        $this->view('auth/register');
    }

    public function registerProcess()
    {
        if (!$this->isPost()) {
            $this->redirect(url('index.php?action=register'));
        }

        $username = $this->input('username');
        $password = $this->input('password');
        $email = $this->input('email');
        $phone = $this->input('phone');
        $address = $this->input('address');
        $confirm_password = $this->input('confirm_password');
        
        // validate email
        $errors = [];

        if (empty($username)) { 
            $errors[] = "Please enter your full name";
        }
        
        if (empty($email)) {
            $errors[] = "Please enter your email";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address";
        }
        
        if (empty($password)) {
            $errors[] = "Please enter your password";
        } elseif (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }
        
        if ($password !== $confirm_password) {
            $errors[] = "Confirm password does not match";
        }

        if (!empty($errors)) {
            $this->setFlash('errors', $errors);
            $this->setFlash('old_username', $username);
            $this->setFlash('old_email', $email);
            $this->redirect(url('index.php?action=register'));  
            exit();
        }

        // Check email exists
        $user = $this->model('User');

        if ($user->emailExists($email)) {
            $this->setFlash('errors', ['Email already exists']);
            $this->setFlash('old_username', $username);
            $this->setFlash('old_email', $email);
            $this->redirect(url('index.php?action=register'));  
            exit();
        }

        if ($user->create($username, $password, $email, $phone, $address)) {
            $this->setFlash('success', 'Registration successful');
            $this->redirect(url('index.php?action=login')); 
        } else {
            $this->setFlash('errors', ['Registration failed, please try again']);
            $this->redirect(url('index.php?action=register'));  
            exit();
        }
    }

    public function changePasswordForm()
    {
        // Require user to be logged in
        if (!$this->isLoggedIn()) {
            $this->setFlash('error', 'Please log in to perform this function');
            $this->redirect(url('index.php?action=login'));
            return;
        }

        $this->view('account/change-password');
    }

    public function changePassword()
    {
        // Require user to be logged in and the request to be POST
        if (!$this->isLoggedIn() || !$this->isPost()) {
            $this->redirect(url('index.php?action=login'));
            return;
        }

        $current_password = $this->input('current_password');
        $new_password = $this->input('new_password');
        $confirm_new_password = $this->input('confirm_new_password');
        $user_id = $_SESSION['user_id'];
        
        $errors = [];

        // --- Validation ---
        if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
            $errors[] = "Please fill out all information fields completely.";
        }
        if (strlen($new_password) < 8) {
            $errors[] = "The new password must have at least 8 characters.";
        }
        if ($new_password !== $confirm_new_password) {
            $errors[] = "New password and confirmation do not match.";
        }

        if (!empty($errors)) {
            $this->setFlash('errors', $errors);
            $this->redirect(url('index.php?action=change-password'));
            return;
        }

        // --- Password Verification ---
        $userModel = $this->model('User');
        $user = $userModel->findById($user_id);

        if (!$user || !password_verify($current_password, $user['password'])) {
            $this->setFlash('errors', ['The current password is incorrect.']);
            $this->redirect(url('index.php?action=change-password'));
            return;
        }

        // --- Update Password ---
        $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);
        if ($userModel->updatePassword($user_id, $hashedPassword)) {
            $this->setFlash('success', 'Password has been changed successfully.');
            // Redirect to profile page or index
            $this->redirect(url('index.php'));
        } else {
            $this->setFlash('errors', ['An error has occurred. Please try again.']);
            $this->redirect(url('index.php?action=change-password'));
        }
    }
}