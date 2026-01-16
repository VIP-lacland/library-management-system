<?php
/**
 * Configuration File
 * Contains all application constants and settings
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library_management');

// Application Configuration
define('APP_NAME', 'Simple MVC Example');
define('APP_VERSION', '1.0.0');

// URL Configuration
// MUST match your project folder + public
define('URL_ROOT', '/library-management-system/public');


// Path Configuration
define('APP_ROOT', dirname(dirname(__FILE__)));

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // 1 only if HTTPS

// Start session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
