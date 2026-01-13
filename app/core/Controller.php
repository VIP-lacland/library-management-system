<?php
/**
 * Base Controller Class
 * All controllers should extend this class
 */

class Controller
{
  /**
   * Load a view file
   * @param string $view - View file path (relative to app/views/)
   * @param array $data - Data to pass to the view
   */
  protected function view($view, $data = [])
  {
    // Sanitize view path to prevent directory traversal (allow forward slashes for subdirectories)
    $view = str_replace(['..', '\\'], '', $view);
    // Normalize path separators
    $view = str_replace('\\', '/', $view);
    
    // Build view file path using APP_ROOT constant
    $viewFile = APP_ROOT . "/app/views/{$view}.php";

    // Check if view file exists
    if (file_exists($viewFile)) {
      // Extract data array to variables (safer with EXTR_SKIP flag)
      extract($data, EXTR_SKIP);
      require_once $viewFile;
    } else {
      // Better error handling
      error_log("View not found: {$view}");
      if (ini_get('display_errors')) {
        die("View not found: {$view}");
      } else {
        die("View not found. Please contact the administrator.");
      }
    }
  }

  /**
   * Load a view file with layout (header and footer)
   * @param string $view - View file path (relative to app/views/)
   * @param array $data - Data to pass to the view
   * @param string $layout - Layout name (default: 'default')
   */
  protected function viewWithLayout($view, $data = [], $layout = 'default')
  {
    // Extract data array to variables
    extract($data, EXTR_SKIP);
    
    // Include header
    $headerFile = APP_ROOT . "/app/views/layouts/header.php";
    if (file_exists($headerFile)) {
      require_once $headerFile;
    }
    
    // Include the main view content
    $this->view($view, $data);
    
    // Include footer
    $footerFile = APP_ROOT . "/app/views/layouts/footer.php";
    if (file_exists($footerFile)) {
      require_once $footerFile;
    }
  }

  /**
   * Load a model
   * @param string $model - Model class name
   * @return object - Instance of the model
   */
  protected function model($model)
  {
    // Sanitize model name to prevent directory traversal
    $model = str_replace(['..', '/', '\\'], '', $model);
    
    // Build model file path using APP_ROOT constant
    $modelFile = APP_ROOT . "/app/models/{$model}.php";

    // Check if model file exists
    if (file_exists($modelFile)) {
      require_once $modelFile;
      
      // Check if class exists before instantiating
      if (class_exists($model)) {
        return new $model();
      } else {
        error_log("Model class '{$model}' not found in file: {$modelFile}");
        die("Model class '{$model}' not found");
      }
    } else {
      // Better error handling
      error_log("Model file not found: {$model}");
      if (ini_get('display_errors')) {
        die("Model not found: {$model}");
      } else {
        die("Model not found. Please contact the administrator.");
      }
    }
  }

  /**
   * Redirect to another page
   * @param string $url - URL to redirect to
   */
  protected function redirect($url)
  {
    // Ensure URL is not empty and starts with /
    if (empty($url)) {
      $url = '/';
    } elseif ($url[0] !== '/') {
      $url = '/' . $url;
    }
    
    // Prevent header injection
    $url = filter_var($url, FILTER_SANITIZE_URL);
    
    header("Location: " . URL_ROOT . $url);
    exit;
  }

  /**
   * Check if user is logged in
   * @return bool
   */
  protected function isLoggedIn()
  {
    return isset($_SESSION['user_id']);
  }

  /**
   * Check if user is admin
   * @return bool
   */
  protected function isAdmin()
  {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
  }

  /**
   * Require login - redirect to login page if not logged in
   */
  protected function requireLogin()
  {
    if (!$this->isLoggedIn()) {
      $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
      $this->redirect('/auth/login');
    }
  }

  /**
   * Require admin - redirect if not admin
   */
  protected function requireAdmin()
  {
    $this->requireLogin();
    if (!$this->isAdmin()) {
      $_SESSION['error'] = "You don't have permission to access this page.";
      $this->redirect('/');
    }
  }
}