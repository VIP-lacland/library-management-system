<?php
require_once '../app/config/config.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

// User Controllers
require_once('../app/controllers/BookController.php');
require_once('../app/controllers/AccountController.php');
require_once('../app/controllers/AuthController.php');


// Admin Controllers
// require_once('../app/controllers/admin/AdminController.php');
// require_once('../app/controllers/admin/BookController.php');
// require_once('../app/controllers/admin/CategoryController.php');
// require_once('../app/controllers/admin/DashboardController.php');
// require_once('../app/controllers/admin/BorrowingController.php');
// require_once('../app/controllers/admin/UserController.php');


// Get action from URL parameter, default to 'index' if not provided
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Initialize user controllers
$bookController = new BookController();
$accountController = new AccountController();
$authController = new AuthController();


// Initialize admin controller 
// $adminController = new AdminController();
// $bookController = new AdminBookController();
// $categoryController = new CategoryController();
// $dashboardController = new DashboardController();
// $borrowingController = new BorrowingController();
// $userController = new AdminUserController();


// Route based on action parameter
switch ($action) {
    case 'index':
    case '':
        $bookController->index();
        break;
    case 'book-detail':
        // select ID from query parameter
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($id === null || $id <= 0) {
            die('Invalid book ID');
        }

        $bookController->detail($id);
        break;
    case 'register':
        $accountController->register();
        break;
    case 'register/process':
        $accountController->registerProcess();
        break;
    case 'login':
        // Check if POST request (login process) or GET request (login form)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $authController->loginForm();
        }
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'change-password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accountController->changePassword();
        } else {
            $accountController->changePasswordForm();
        }
        break;
    case 'forgot-password':
        // Check if POST request (process) or GET request (form)
        $authController->forgotPassword();
        break;
    case 'reset-password':
        // Check if POST request (process) or GET request (form)
        $authController->resetPassword();
        break;
    default:
        // Default to index page if action is not recognized
        $bookController->index();
        break;
}


