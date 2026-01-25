<?php
session_start();


// if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
//     header('Location: index.php?action=login');
//     exit();
// }

require_once '../app/config/config.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

// Admin Controllers ONLY
require_once '../app/controllers/admin/AdminBookController.php';
require_once '../app/controllers/admin/CategoryController.php';
require_once '../app/models/Book.php';
require_once '../app/models/Category.php';


$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

$categoryController = new CategoryController();
$adminBookController = new AdminBookController();

switch ($action) {
    case 'dashboard':
        // Gọi trang Dashboard chính của Admin
        require_once '../app/views/admin/dashboard.php';
        break;

    // ================= CATEGORY CRUD =================
    case 'categories':
        $categoryController->index();
        break;
    case 'category-create':
        $categoryController->create();
        break;
    case 'category-store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $categoryController->store();
        break;
    case 'category-edit':
        $categoryController->edit();
        break;
    case 'category-update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $categoryController->update();
        break;
    case 'category-delete':
        $categoryController->delete();
        break;

    // ================= BOOK CRUD =================
    case 'admin-books':
        $adminBookController->index();
        break;
    case 'admin-book-create':
        $adminBookController->create();
        break;
    case 'admin-book-store':
        $adminBookController->store();
        break;
    case 'admin-book-edit':
        $adminBookController->edit();
        break;
    case 'admin-book-update':
        $adminBookController->update();
        break;
    case 'admin-book-delete':
        $adminBookController->delete();
        break;

    default:
        header('Location: admin.php?action=dashboard');
        break;
}