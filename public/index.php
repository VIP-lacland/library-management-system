<?php
require_once '../app/config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';


require_once('../app/controllers/BookController.php');
require_once('../app/controllers/AccountController.php');

// Get action from URL parameter, default to 'index' if not provided
$action = isset($_GET['action']) ? $_GET['action'] : 'index';



$bookController = new BookController();
$accountController = new AccountController();

// Route based on action parameter
switch ($action) {
    case 'index':
    case '':
        $bookController->index();
        break;
    case 'register':
        $accountController->register();
        break;
    case 'register/process':
        $accountController->registerProcess();
        break;
    default:
        // Default to index page if action is not recognized
        $bookController->index();
        break;
}

?>
