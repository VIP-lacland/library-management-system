<?php

class Router
{
    private $routes = [];

    public function get($path, $controller, $method)
    {
        $this->routes['GET'][$path] = [$controller, $method];
    }

    public function post($path, $controller, $method)
    {
        $this->routes['POST'][$path] = [$controller, $method];
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = isset($_GET['url']) ? '/' . trim($_GET['url'], '/') : '/';

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo "404 - Page Not Found<br>";
            echo "Method: $method<br>";
            echo "URI: $uri";
            return;
        }

        [$controller, $action] = $this->routes[$method][$uri];

        require_once APP_ROOT . '/app/controllers/' . $controller . '.php';


        $obj = new $controller();
        call_user_func([$obj, $action]);
    }
}
