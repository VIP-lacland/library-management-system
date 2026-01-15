<?php

require_once '../app/config/config.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

// Lấy URL từ $_GET['url'] hoặc mặc định là 'book'
$url = $_GET['url'] ?? 'book/index';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Xác định Controller - mặc định là 'BookController'
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'BookController';
$controllerFile = "../app/controllers/{$controllerName}.php";

if (!file_exists($controllerFile)) {
    die("Error: Controller '$controllerName' does not exist");
}

require_once $controllerFile;

// Xác định phương thức - mặc định là 'index'
$method = !empty($url[1]) ? $url[1] : 'index';

// Lấy tham số từ URL
$param = !empty($url[2]) ? $url[2] : null;

// Kiểm tra Controller có tồn tại không
if (!class_exists($controllerName)) {
    die("Error: Class '$controllerName' does not exist");
}

// Khởi tạo Controller
$controller = new $controllerName();

// Kiểm tra phương thức tồn tại không
if (!method_exists($controller, $method)) {
    die("Error: Method '$method' does not exist in '$controllerName'");
}

// Gọi phương thức với tham số
if ($param !== null) {
    $controller->$method($param);
} else {
    $controller->$method();
}
?>
