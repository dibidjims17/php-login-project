<?php
require 'vendor/autoload.php';
use MongoDB\Client;

try {
    // Connect to MongoDB
    $mongo = new Client("mongodb://localhost:27017");
    $db = $mongo->finals_system;

    // Hash the password
    $password = password_hash('admin123', PASSWORD_DEFAULT);

    // Insert admin user
    $db->users->insertOne([
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => $password,
        'role' => 'admin',
        'verified' => true
    ]);

    echo "Admin account created successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
