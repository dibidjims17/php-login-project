<?php
require 'config.php';
protect_page();

if ($_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

$id = $_GET['id'] ?? '';
$item = $db->items->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if (!$item) {
    die("Item not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm'])) {
        $db->items->deleteOne(['_id' => $item['_id']]);
        redirect("dashboard.php?page=items");
    } else {
        redirect("dashboard.php?page=items");
    }
}
?>

<h2>Delete Item</h2>
<p>Are you sure you want to delete the following item?</p>

<ul>
    <li><strong>Code:</strong> <?= htmlspecialchars($item['code']) ?></li>
    <li><strong>Name:</strong> <?= htmlspecialchars($item['name']) ?></li>
    <li><strong>Description:</strong> <?= htmlspecialchars($item['description'] ?? '-') ?></li>
    <li><strong>Quantity:</strong> <?= $item['quantity'] ?></li>
    <li><strong>Added By:</strong> <?= htmlspecialchars($item['added_by'] ?? '-') ?></li>
</ul>

<form method="POST">
    <button type="submit" name="confirm">Yes, Delete</button>
    <button type="submit" name="cancel">Cancel</button>
</form>
