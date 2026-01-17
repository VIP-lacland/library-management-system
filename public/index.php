<?php

require_once '../app/config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Router.php';

/*
|--------------------------------------------------------------------------
| ROUTES
|--------------------------------------------------------------------------
*/

// ===== BOOK =====
$router->get('/', 'BookController', 'index');
$router->get('/books', 'BookController', 'index');
$router->get('/books/:id', 'BookController', 'show');
$router->post('/books', 'BookController', 'store');
$router->get('/books/:id/edit', 'BookController', 'edit');
$router->put('/books/:id', 'BookController', 'update');
$router->delete('/books/:id', 'BookController', 'delete');

// ===== AUTH =====
$router->get('/login', 'AuthController', 'loginForm');
$router->post('/login', 'AuthController', 'login');
$router->get('/logout', 'AuthController', 'logout');

$router->get('/register', 'AuthController', 'registerForm');
$router->post('/register', 'AuthController', 'register');

$router->get('/forgot-password', 'AuthController', 'forgotPasswordForm');
$router->post('/forgot-password', 'forgotPassword');

$router->get('/reset-password', 'AuthController', 'resetPasswordForm');
$router->post('/reset-password', 'resetPassword');

// ===== DASHBOARD =====
$router->get('/dashboard', 'DashboardController', 'index');

/*
|--------------------------------------------------------------------------
| RUN
|--------------------------------------------------------------------------
*/
$router->dispatch();
