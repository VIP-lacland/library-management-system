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
    // Extract data array to variables
    extract($data);

    // Build view file path
    $viewFile = "../app/views/{$view}.php";

    // Check if view file exists
    if (file_exists($viewFile)) {
      require_once $viewFile;
    } else {
      die("View not found: {$view}");
    }
  }

  /**
   * Load a model
   * @param string $model - Model class name
   * @return object - Instance of the model
   */
  protected function model($model)
  {
    // Build model file path
    $modelFile = "../app/models/{$model}.php";

    // Check if model file exists
    if (file_exists($modelFile)) {
      require_once $modelFile;
      return new $model();
    } else {
      die("Model not found: {$model}");
    }
  }

  /**
   * Redirect to another page
   * @param string $url - URL to redirect to
   */
  protected function redirect($url)
  {
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