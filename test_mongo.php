<?php
require 'vendor/autoload.php'; // Composer autoload
use MongoDB\Client;

try {
    // Connect to MongoDB server
    $mongo = new Client("mongodb://localhost:27017");

    // Select your database
    $db = $mongo->finals_system;

    // Access the "users" collection
    $collection = $db->users;

    // Insert a test record
    $insertResult = $collection->insertOne([
        'name' => 'PHP Test User',
        'email' => 'php_test@example.com'
    ]);

    echo "Inserted with ID: " . $insertResult->getInsertedId();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
