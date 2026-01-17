<?php
require_once '../config/config.php';
require_once '../app/core/Router.php';

$router = new Router();

// ===== ROUTE DEVELOP =====
$router->get('/', 'BookController', 'index');
$router->get('/books', 'BookController', 'index');
$router->get('/books/:id', 'BookController', 'show');
$router->post('/books', 'BookController', 'store');
$router->get('/books/:id/edit', 'BookController', 'edit');
$router->put('/books/:id', 'BookController', 'update');
$router->delete('/books/:id', 'BookController', 'delete');

// ===== ROUTE LOGIN =====
$router->get('/auth', 'AuthController', 'loginForm');
$router->post('/auth/login', 'AuthController', 'login');
$router->get('/logout', 'AuthController', 'logout');
$router->get('/forgot-password', 'AuthController', 'forgotPassword');
$router->post('/forgot-password', 'AuthController', 'forgotPassword');
$router->get('/reset-password', 'AuthController', 'resetPassword');
$router->post('/reset-password', 'AuthController', 'resetPassword');
$router->get('/dashboard', 'DashboardController', 'index');

// ===== RUN =====
$router->dispatch();
