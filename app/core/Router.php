<?php
/**
 * Router Class
 * Handles routing for the MVC application
 */

class Router
{
  /**
   * Array to store registered routes
   * @var array
   */
  private $routes = [];

  /**
   * Array to store route parameters
   * @var array
   */
  private $params = [];

  /**
   * Register a GET route
   * @param string $route - URL pattern
   * @param string $controller - Controller class name
   * @param string $method - Method name in controller
   */
  public function get($route, $controller, $method)
  {
    $this->addRoute('GET', $route, $controller, $method);
  }

  /**
   * Register a POST route
   * @param string $route - URL pattern
   * @param string $controller - Controller class name
   * @param string $method - Method name in controller
   */
  public function post($route, $controller, $method)
  {
    $this->addRoute('POST', $route, $controller, $method);
  }

  /**
   * Register a PUT route
   * @param string $route - URL pattern
   * @param string $controller - Controller class name
   * @param string $method - Method name in controller
   */
  public function put($route, $controller, $method)
  {
    $this->addRoute('PUT', $route, $controller, $method);
  }

  /**
   * Register a DELETE route
   * @param string $route - URL pattern
   * @param string $controller - Controller class name
   * @param string $method - Method name in controller
   */
  public function delete($route, $controller, $method)
  {
    $this->addRoute('DELETE', $route, $controller, $method);
  }

  /**
   * Add a route to the routes array
   * @param string $method - HTTP method
   * @param string $route - URL pattern
   * @param string $controller - Controller class name
   * @param string $action - Method name in controller
   */
  private function addRoute($method, $route, $controller, $action)
  {
    // Convert route pattern to regex
    $route = $this->convertRouteToRegex($route);

    $this->routes[] = [
      'method' => $method,
      'route' => $route,
      'controller' => $controller,
      'action' => $action
    ];
  }

  /**
   * Convert route pattern to regex
   * Supports parameters like :id, :slug, etc.
   * @param string $route - Route pattern
   * @return string - Regex pattern
   */
  private function convertRouteToRegex($route)
  {
    // Escape forward slashes
    $route = preg_replace('/\//', '\/', $route);

    // Replace :parameter with regex pattern
    $route = preg_replace('/:([a-zA-Z0-9_]+)/', '(?P<$1>[a-zA-Z0-9_-]+)', $route);

    // Add start and end anchors
    return '/^' . $route . '$/';
  }

  /**
   * Match current URL with registered routes
   * @param string $url - Current URL
   * @param string $method - HTTP method
   * @return bool - True if route matches
   */
  private function matchRoute($url, $method)
  {
    foreach ($this->routes as $route) {
      // Check if HTTP method matches
      if ($route['method'] !== $method) {
        continue;
      }

      // Check if URL matches route pattern
      if (preg_match($route['route'], $url, $matches)) {
        // Extract parameters
        $this->params = [];
        foreach ($matches as $key => $value) {
          if (is_string($key)) {
            $this->params[$key] = $value;
          }
        }

        // Store controller and action
        $this->params['controller'] = $route['controller'];
        $this->params['action'] = $route['action'];

        return true;
      }
    }

    return false;
  }

  /**
   * Get current URL path
   * @return string - URL path
   */
  private function getCurrentUrl()
  {
    $url = $_SERVER['REQUEST_URI'] ?? '/';

    // Remove query string
    if (($pos = strpos($url, '?')) !== false) {
      $url = substr($url, 0, $pos);
    }

    // Remove URL_ROOT prefix if present
    $urlRoot = rtrim(URL_ROOT, '/');
    if ($urlRoot && strpos($url, $urlRoot) === 0) {
      $url = substr($url, strlen($urlRoot));
    }

    // Ensure URL starts with /
    if ($url === '' || $url[0] !== '/') {
      $url = '/' . $url;
    }

    return $url;
  }

  /**
   * Get HTTP method
   * Supports method override via _method parameter
   * @return string - HTTP method
   */
  private function getMethod()
  {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    // Support method override for PUT/DELETE
    if ($method === 'POST' && isset($_POST['_method'])) {
      $method = strtoupper($_POST['_method']);
    }

    return $method;
  }

  /**
   * Load controller file
   * @param string $controller - Controller class name
   * @return bool - True if file exists
   */
  private function loadController($controller)
  {
    // Require base Controller class first (same directory as Router)
    $controllerBaseFile = __DIR__ . "/Controller.php";
    if (file_exists($controllerBaseFile) && !class_exists('Controller')) {
      require_once $controllerBaseFile;
    }
    
    // Sanitize controller name to prevent directory traversal
    $controller = str_replace(['..', '/', '\\'], '', $controller);
    
    // Build controller file path
    $controllerFile = __DIR__ . "/../controllers/{$controller}.php";

    if (file_exists($controllerFile)) {
      require_once $controllerFile;
      return true;
    }

    return false;
  }

  /**
   * Dispatch the request to the appropriate controller and method
   */
  public function dispatch()
  {
    $url = $this->getCurrentUrl();
    $method = $this->getMethod();

    // Try to match route
    if ($this->matchRoute($url, $method)) {
      $controller = $this->params['controller'];
      $action = $this->params['action'];

      // Remove controller and action from params
      unset($this->params['controller']);
      unset($this->params['action']);

      // Load controller file
      if ($this->loadController($controller)) {
        // Check if controller class exists
        if (class_exists($controller)) {
          // Instantiate controller
          $controllerInstance = new $controller();

          // Check if method exists
          if (method_exists($controllerInstance, $action)) {
            // Call controller method with parameters
            call_user_func_array([$controllerInstance, $action], $this->params);
            return;
          } else {
            die("Method '{$action}' not found in controller '{$controller}'");
          }
        } else {
          die("Controller class '{$controller}' not found");
        }
      } else {
        die("Controller file '{$controller}.php' not found");
      }
    }

    // No route matched - 404 error
    $this->handle404();
  }

  /**
   * Handle 404 Not Found error
   */
  private function handle404()
  {
    http_response_code(404);
    die("404 - Page Not Found");
  }
}

