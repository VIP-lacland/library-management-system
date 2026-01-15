<?php
require_once '../config/config.php';
require_once '../app/core/Router.php';

$router = new Router();

$router->get('/', 'BookController', 'index');
$router->get('/books', 'BookController', 'index');

$router->get('/auth', 'AuthController', 'loginForm');
$router->post('/auth/login', 'AuthController', 'login');
$router->get('/logout', 'AuthController', 'logout');

$router->get('/dashboard', 'DashboardController', 'index');


$router->get('/forgot-password', 'AuthController', 'forgotPassword');

$router->dispatch();
