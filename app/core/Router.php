<?php

class Router
{
  private $routes = [];
  private $params = [];

  public function get($route, $controller, $method)
  {
    $this->addRoute('GET', $route, $controller, $method);
  }

  public function post($route, $controller, $method)
  {
    $this->addRoute('POST', $route, $controller, $method);
  }

  public function put($route, $controller, $method)
  {
    $this->addRoute('PUT', $route, $controller, $method);
  }

  public function delete($route, $controller, $method)
  {
    $this->addRoute('DELETE', $route, $controller, $method);
  }

  private function addRoute($method, $route, $controller, $action)
  {
    $route = $this->convertRouteToRegex($route);

    $this->routes[] = [
      'method' => $method,
      'route' => $route,
      'controller' => $controller,
      'action' => $action
    ];
  }

  private function convertRouteToRegex($route)
  {
    $route = preg_replace('/\//', '\/', $route);
    $route = preg_replace('/:([a-zA-Z0-9_]+)/', '(?P<$1>[a-zA-Z0-9_-]+)', $route);
    return '/^' . $route . '$/';
  }

  private function matchRoute($url, $method)
  {
    foreach ($this->routes as $route) {
      if ($route['method'] !== $method) continue;

      if (preg_match($route['route'], $url, $matches)) {
        $this->params = [];

        foreach ($matches as $key => $value) {
          if (is_string($key)) {
            $this->params[$key] = $value;
          }
        }

        $this->params['controller'] = $route['controller'];
        $this->params['action'] = $route['action'];

        return true;
      }
    }
    return false;
  }

  private function getCurrentUrl()
  {
    $url = $_SERVER['REQUEST_URI'] ?? '/';

    if (($pos = strpos($url, '?')) !== false) {
      $url = substr($url, 0, $pos);
    }

    $urlRoot = rtrim(URL_ROOT, '/');
    if ($urlRoot && strpos($url, $urlRoot) === 0) {
      $url = substr($url, strlen($urlRoot));
    }

    if ($url === '' || $url[0] !== '/') {
      $url = '/' . $url;
    }

    return $url;
  }

  private function getMethod()
  {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    if ($method === 'POST' && isset($_POST['_method'])) {
      $method = strtoupper($_POST['_method']);
    }

    return $method;
  }

  private function loadController($controller)
  {
    $controller = str_replace(['..', '/', '\\'], '', $controller);
    $controllerFile = __DIR__ . "/../controllers/{$controller}.php";

    if (file_exists($controllerFile)) {
      require_once $controllerFile;
      return true;
    }

    return false;
  }

  public function dispatch()
  {
    $url = $this->getCurrentUrl();
    $method = $this->getMethod();

    if ($this->matchRoute($url, $method)) {
      $controller = $this->params['controller'];
      $action = $this->params['action'];

      unset($this->params['controller'], $this->params['action']);

      if ($this->loadController($controller)) {
        $controllerInstance = new $controller();

        if (method_exists($controllerInstance, $action)) {
          call_user_func_array([$controllerInstance, $action], $this->params);
          return;
        } else {
          die("Method '{$action}' not found");
        }
      } else {
        die("Controller file not found");
      }
    }

    http_response_code(404);
    die("404 - Page Not Found");
  }
}
