<?php

require_once '../app/config/config.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

// Lấy URL từ REQUEST_URI
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Loại bỏ base path nếu có (e.g., /public hoặc /library-management-system/public)
$base_paths = ['/library-management-system/public', '/public', ''];
$url = $request_uri;

foreach ($base_paths as $base_path) {
    if ($base_path && strpos($request_uri, $base_path) === 0) {
        $url = substr($request_uri, strlen($base_path));
        break;
    }
}

// Loại bỏ leading/trailing slashes
$url = trim($url, '/');

// Nếu URL rỗng hoặc là index.php, mặc định là 'book/index'
if (empty($url) || $url === 'index.php') {
    $url = 'book/index';
}

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

// Lấy tất cả tham số từ URL
$params = [];
for ($i = 2; $i < count($url); $i++) {
    $params[] = $url[$i];
}

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
if (!empty($params)) {
    call_user_func_array([$controller, $method], $params);
} else {
    $controller->$method();
}
?>
