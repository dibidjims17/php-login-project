<?php
require 'config.php';
protect_page();

if ($_SESSION['role'] !== 'user') {
    die("Access denied. Users only.");
}

$itemId = $_GET['id'] ?? null;
if (!$itemId) {
    die("No item selected.");
}

// Fetch item
$item = $db->items->findOne(['_id' => new MongoDB\BSON\ObjectId($itemId)]);
if (!$item) {
    die("Item not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = (int)$_POST['quantity'];
    if ($quantity > 0 && $quantity <= $item['quantity']) {
        $db->borrows->insertOne([
            'user_id' => new MongoDB\BSON\ObjectId($_SESSION['user_id']),
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email'],
            'item_id' => $item['_id'],
            'item_name' => $item['name'],
            'item_code' => $item['code'],
            'quantity' => $quantity,
            'borrowed_at' => new MongoDB\BSON\UTCDateTime(),
            'status' => 'Pending', // if using pending/approval system
        ]);
        echo "<p>Request sent to borrow {$quantity} x {$item['name']}.</p>";
    } else {
        echo "<p>Invalid quantity.</p>";
    }
}
?>
<h2>Borrow Item: <?= htmlspecialchars($item['name']) ?></h2>
<form method="POST">
    <label>Quantity:</label>
    <input type="number" name="quantity" min="1" max="<?= $item['quantity'] ?>" value="1" required>
    <br><br>
    <button type="submit">Borrow</button>
    <a href="dashboard.php?page=user_items"><button type="button">Cancel</button></a>
</form>
