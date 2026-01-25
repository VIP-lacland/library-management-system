<?php
session_start();

require_once '../app/config/config.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

// User Controllers ONLY
require_once '../app/controllers/AccountController.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/BookController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$bookController    = new BookController();
$accountController = new AccountController();
$authController    = new AuthController();

switch ($action) {
    case 'index':
    case '':
        $bookController->index();
        break;

    case 'book-detail':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) die('Invalid book ID');
        $bookController->detail($id);
        break;

    case 'register':
        $accountController->register();
        break;

    case 'register/process':
        $accountController->registerProcess();
        break;

    case 'login':
        ($_SERVER['REQUEST_METHOD'] === 'POST') ? $authController->login() : $authController->loginForm();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'change-password':
        ($_SERVER['REQUEST_METHOD'] === 'POST') ? $accountController->changePassword() : $accountController->changePasswordForm();
        break;

    case 'forgot-password':
        $authController->forgotPassword();
        break;

    case 'reset-password':
        $authController->resetPassword();
        break;

    default:
        $bookController->index();
        break;
}