<?php

class AccountController extends Controller
{
    public function register()
    {
        // If logged in, return to the home page
        if (isset($_SESSION['user_id'])) {
            $this->redirect(url('index.php'));
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
}