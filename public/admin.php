<?php
// public/admin.php
require_once '../app/config/config.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['flash']['error'] = 'Bạn không có quyền truy cập.';
    header('Location: index.php?action=login');
    exit;
}

// Admin Controllers
require_once('../app/controllers/admin/DashboardController.php');
require_once('../app/controllers/admin/AdminBookController.php');
require_once('../app/controllers/admin/AdminUserController.php');
require_once('../app/controllers/admin/CategoryController.php');
require_once('../app/controllers/admin/BorrowingController.php');

// Get action from URL
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

// Initialize controllers
$dashboardController = new DashboardController();
// $bookController = new AdminBookController();
$userController = new AdminUserController();
// $categoryController = new AdminCategoryController();
// $borrowingController = new AdminBorrowingController();

// Admin routing
switch ($action) {
    // Dashboard
    case 'dashboard':
        $dashboardController->index();
        break;

    // User Management
    case 'users':
        $userController->getAllUser();
        break;

    case 'blockUser':
        $userController->blockUser();
        break;

    case 'unblockUser':
        $userController->unblockUser();
        break;
    default:
        $dashboardController->index();
        break;
}