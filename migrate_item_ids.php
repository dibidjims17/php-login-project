<?php
require 'config.php';

echo "<h2>Starting ItemID migration...</h2>";

// 1️⃣ Update all items with a code
$items = $db->items->find()->toArray();
foreach ($items as $index => $item) {
    $itemID = sprintf("ITM%03d", $index + 1); // ITM001, ITM002...
    $db->items->updateOne(
        ['_id' => $item['_id']],
        ['$set' => ['code' => $itemID]]
    );
    echo "Assigned $itemID to item: " . ($item['name'] ?? '-') . "<br>";
}

// 2️⃣ Update past borrow logs with ItemID
$borrows = $db->borrows->find()->toArray();
foreach ($borrows as $log) {
    $item = $db->items->findOne(['_id' => $log['item_id']]);
    if ($item && isset($item['code'])) {
        $db->borrows->updateOne(
            ['_id' => $log['_id']],
            ['$set' => ['ItemID' => $item['code']]]
        );
        echo "Updated borrow log for user: " . ($log['username'] ?? '-') . " with ItemID: " . $item['code'] . "<br>";
    } else {
        $db->borrows->updateOne(
            ['_id' => $log['_id']],
            ['$set' => ['ItemID' => '-']]
        );
        echo "Set ItemID to '-' for borrow log of user: " . ($log['username'] ?? '-') . "<br>";
    }
}

echo "<h3>Migration completed!</h3>";
