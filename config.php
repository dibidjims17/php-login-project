<?php
// config.php

require __DIR__ . '/vendor/autoload.php'; // Composer autoload
use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Connect to MongoDB
    $mongo = new Client("mongodb://localhost:27017");
    $db = $mongo->finals_system; // your database
} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}

/**
 * Check if user is logged in
 */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is admin
 */
function is_admin(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Protect page: redirect to login if not logged in
 */
function protect_page(): void {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Optional: Remember-me token handling
 * Usage: call at the start of pages to auto-login
 */
function check_remember_me($db): void {
    if (!isset($_SESSION['user_id']) && isset($_COOKIE['rememberme'])) {
        $token = $_COOKIE['rememberme'];
        $user = $db->users->findOne(['remember_token' => $token]);

        if ($user) {
            $_SESSION['user_id'] = (string)$user['_id'];
            $_SESSION['username'] = $user['username'] ?? '';
            $_SESSION['role'] = $user['role'] ?? 'user';
        } else {
            // Invalid token, delete cookie
            setcookie('rememberme', '', time() - 3600, '/');
        }
    }
}

// Auto-login if remember-me cookie exists
check_remember_me($db);
