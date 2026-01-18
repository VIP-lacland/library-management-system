<?php
/**
 * Configuration File
 */

// Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library_management');

// App Info
define('APP_NAME', 'Library Management System');

// URL
define('BASE_URL', 'http://localhost:3000/public');

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Error Display
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Helper Functions
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

function asset($file) {
    return BASE_URL . '/' . ltrim($file, '/');
}