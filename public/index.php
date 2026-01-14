<?php
// Trong public/index.php
require_once '../config/config.php';
require_once '../app/core/Router.php';

$router = new Router();

// Đăng ký các route
$router->get('/', 'BookController', 'index');
$router->get('/books', 'BookController', 'index');
$router->get('/books/:id', 'BookController', 'show');
$router->post('/books', 'BookController', 'store');
$router->get('/books/:id/edit', 'BookController', 'edit');
$router->put('/books/:id', 'BookController', 'update');
$router->delete('/books/:id', 'BookController', 'delete');

// Xử lý request
$router->dispatch();





?>