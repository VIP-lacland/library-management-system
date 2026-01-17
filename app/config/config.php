<?php
/**
 * Configuration File
 * Contains all application constants and settings
 */

// Database Configuration
define('DB_HOST', 'localhost:3307');
define('DB_USER', 'root');
define('DB_PASS', 'Beng1936&');
define('DB_NAME', 'library_management');

// Application Configuration

define('APP_NAME', 'Library Management System');
define('APP_VERSION', '1.0.0');

// URL Configuration (sửa đúng theo thư mục của em)
define('BASE_URL', 'http://localhost/library-management-system/public');
define('URL_ROOT', '/library-management-system/public');


// Path Configuration
define('APP_ROOT', dirname(dirname(dirname(__FILE__))));
define('PUBLIC_PATH', APP_ROOT . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0);

// Start session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
