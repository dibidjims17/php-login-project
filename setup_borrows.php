<?php
require 'config.php';
require 'functions.php';

$usersCollection = $db->users;
$itemsCollection = $db->items; // Make sure you have an 'items' collection
$borrowsCollection = $db->borrows;

// Sample items (if you don't have items yet)
$sampleItems = [
    ['name' => 'Hammer', 'quantity' => 10],
    ['name' => 'Screwdriver', 'quantity' => 15],
    ['name' => 'Safety Gloves', 'quantity' => 20],
];

foreach ($sampleItems as $item) {
    $existing = $itemsCollection->findOne(['name' => $item['name']]);
    if (!$existing) {
        $itemsCollection->insertOne($item);
        echo "Inserted item: {$item['name']}\n";
    }
}

// Fetch all regular users
$users = $usersCollection->find(['role' => 'user'])->toArray();

// Create sample borrow logs
foreach ($users as $user) {
    // Randomly pick an item to borrow
    $items = $itemsCollection->find()->toArray();
    $item = $items[array_rand($items)];

    $borrowRecord = [
        'user_id' => $user['_id'],
        'username' => $user['username'],
        'item_id' => $item['_id'],
        'item_name' => $item['name'],
        'quantity' => rand(1, 3),
        'borrowed_at' => new MongoDB\BSON\UTCDateTime(),
        'returned' => false
    ];

    $borrowsCollection->insertOne($borrowRecord);
    echo "Created borrow record for user {$user['username']} borrowing {$item['name']}\n";
}

echo "Sample borrow logs created.\n";
