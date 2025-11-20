<?php
// functions.php

// Sanitize output
if (!function_exists('sanitize')) {
    function sanitize($value) {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}

// Generate random token
if (!function_exists('generateToken')) {
    function generateToken(int $length = 32): string {
        return bin2hex(random_bytes($length));
    }
}

// Optional: Send email (requires mail server setup)
if (!function_exists('sendEmail')) {
    function sendEmail(string $to, string $subject, string $message, string $headers = ''): bool {
        return mail($to, $subject, $message, $headers);
    }
}

// Convert MongoDB ObjectId to string
if (!function_exists('objectIdToString')) {
    function objectIdToString($objectId): string {
        return (string)$objectId;
    }
}
