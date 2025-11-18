<?php
// functions.php

/**
 * Sanitize output to prevent XSS
 */
function sanitize($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to a given URL
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Generate a random token (useful for remember-me or password reset)
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Send an email (example function, requires proper mail setup)
 */
function sendEmail($to, $subject, $message, $headers = '') {
    return mail($to, $subject, $message, $headers);
}

/**
 * Convert MongoDB ObjectId to string safely
 */
function objectIdToString($objectId) {
    return (string)$objectId;
}

/**
 * Optional helper: check if a user is logged in
 * (You can also rely on is_logged_in() in config.php)
 */
function user_logged_in() {
    return isset($_SESSION['user_id']);
}
