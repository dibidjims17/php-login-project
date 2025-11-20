<?php
require 'config.php';
protect_page();

// Only admin can run this
if ($_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

// Fetch all items
$items = $db->items->find();

foreach ($items as $index => $item) {
    // Generate ItemID: e.g., I001, I002, ...
    $itemID = 'I' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

    // Update the item in DB
    $db->items->updateOne(
        ['_id' => $item['_id']],
        ['$set' => ['ItemID' => $itemID]]
    );

    echo "Updated Item: " . htmlspecialchars($item['name']) . " with ItemID: $itemID<br>";
}

echo "<p>All items updated with ItemID!</p>";
