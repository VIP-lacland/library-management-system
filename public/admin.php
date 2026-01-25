<?php
session_start();
require_once '../app/config/config.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

// Tự động load các Controller Admin (hoặc require thủ công)
require_once '../app/controllers/admin/AdminBookController.php';
require_once '../app/controllers/admin/CategoryController.php';

$action = $_GET['action'] ?? 'dashboard';
$adminBook = new AdminBookController();
$category = new CategoryController();

switch ($action) {
    case 'dashboard':
        require_once '../app/views/admin/dashboard.php';
        break;
    case 'admin-books': $adminBook->index(); break;
    case 'admin-book-create': $adminBook->create(); break;
    case 'admin-book-store': $adminBook->store(); break;
    case 'admin-book-edit': $adminBook->edit(); break;
    case 'admin-book-update': $adminBook->update(); break;
    case 'admin-book-delete': $adminBook->delete(); break;
    
    case 'categories': $category->index(); break;
    case 'category-create': $category->create(); break;
    case 'category-store': $category->store(); break;
    case 'category-edit': $category->edit(); break;
    case 'category-update': $category->update(); break;
    case 'category-delete': $category->delete(); break;
    default: header('Location: admin.php?action=dashboard'); break;
}