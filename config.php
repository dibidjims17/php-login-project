<?php
// config.php

require_once __DIR__ . '/vendor/autoload.php'; // Composer autoload
use MongoDB\Client;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $mongo = new MongoDB\Client("mongodb://localhost:27017");
    $db = $mongo->finals_system;

    // Collections
    $users_col = $db->users;
    $items_col = $db->items;
    $borrow_log_col = $db->borrow_log;

} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}


// --------------------
// Helper Functions
// --------------------

// Check if user is logged in
if (!function_exists('is_logged_in')) {
    function is_logged_in(): bool {
        return isset($_SESSION['user_id']);
    }
}

// Check if user is admin
if (!function_exists('is_admin')) {
    function is_admin(): bool {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
}

// Protect a page (redirect if not logged in)
if (!function_exists('protect_page')) {
    function protect_page(): void {
        if (!is_logged_in()) {
            header("Location: login.php");
            exit();
        }
    }
}

// Optional: redirect helper
if (!function_exists('redirect')) {
    function redirect(string $url): void {
        header("Location: $url");
        exit();
    }
}

// Optional: Remember-me auto-login
if (!function_exists('check_remember_me')) {
    function check_remember_me($db): void {
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['rememberme'])) {
            $token = $_COOKIE['rememberme'];
            $user = $db->users->findOne(['remember_token' => $token]);

            if ($user) {
                $_SESSION['user_id'] = (string)$user['_id'];
                $_SESSION['username'] = $user['username'] ?? '';
                $_SESSION['role'] = $user['role'] ?? 'user';
            } else {
                setcookie('rememberme', '', time() - 3600, '/');
            }
        }
    }
}

// Auto-login if remember-me cookie exists
check_remember_me($db);
