<?php
require_once '../app/config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Router.php';

$router = new Router();

// ===== ROUTE DEVELOP =====
$router->get('/', 'BookController', 'index');
$router->get('/books', 'BookController', 'index');

// ===== ROUTE LOGIN =====
$router->get('/auth', 'AuthController', 'loginForm');
$router->post('/auth/login', 'AuthController', 'login');
$router->get('/logout', 'AuthController', 'logout');
$router->get('/forgot-password', 'AuthController', 'forgotPassword');
$router->get('/dashboard', 'DashboardController', 'index');

// ===== RUN =====
$router->dispatch();
