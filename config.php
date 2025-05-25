<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');     // Default phpMyAdmin username
define('DB_PASS', '');         // Default phpMyAdmin password (empty)
define('DB_NAME', 'masked_intel'); // Database name

// Base URL configuration
define('BASE_URL', 'http://localhost/new_php2/'); // Change this according to your setup

// Session configuration
define('SESSION_LIFETIME', 3600); // 1 hour
define('SESSION_NAME', 'MASKED_INTEL_SESSION');

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

// Set session parameters
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
ini_set('session.cookie_lifetime', SESSION_LIFETIME);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Not using HTTPS on localhost
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Lax'); // 'Strict' can cause issues with redirects

// Start session with secure parameters
session_name(SESSION_NAME);
session_start();

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['email']);
}

// Function to redirect with proper base URL
function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit();
}

// Function to redirect to login page
function redirectToLogin() {
    header("Location: " . BASE_URL . "login.php");
    exit();
}
?> 