<?php
require 'config.php'; // Ensure this connects to MongoDB

// Access collections
$items = $db->items;
$borrowLog = $db->borrow_log;

// --- 1. Create sample items ---
$sampleItems = [
    ['name' => 'Hammer', 'quantity' => 10, 'description' => 'Standard steel hammer'],
    ['name' => 'Screwdriver', 'quantity' => 20, 'description' => 'Flathead screwdriver'],
    ['name' => 'Gloves', 'quantity' => 50, 'description' => 'Safety gloves'],
    ['name' => 'Helmet', 'quantity' => 15, 'description' => 'Safety helmet']
];

foreach ($sampleItems as $item) {
    $existingItem = $items->findOne(['name' => $item['name']]);
    if (!$existingItem) {
        $items->insertOne($item);
        echo "Inserted item: {$item['name']}\n";
    } else {
        echo "Item {$item['name']} already exists.\n";
    }
}

// --- 2. Optional: Create a sample borrow log ---
// Uncomment and adjust if you want a sample borrow log

$users = $db->users;
$user = $users->findOne(['email' => 'user@example.com']); // replace with actual user email
$item = $items->findOne(['name' => 'Hammer']);

if ($user && $item) {
    $borrowLog->insertOne([
        'user_id' => $user['_id'],
        'item_id' => $item['_id'],
        'quantity' => 2,
        'borrowed_at' => new MongoDB\BSON\UTCDateTime(),
        'returned_at' => null
    ]);
    echo "Sample borrow log inserted.\n";
}


echo "Collections setup complete.\n";
