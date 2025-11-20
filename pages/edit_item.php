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
    $name = sanitize($_POST['name']);
    $quantity = (int)$_POST['quantity'];
    $description = sanitize($_POST['description'] ?? '');

    $db->items->updateOne(
        ['_id' => $item['_id']],
        ['$set' => [
            'name' => $name,
            'quantity' => $quantity,
            'description' => $description
        ]]
    );

    $success = "Item <strong>$name</strong> updated successfully!";
    // Refresh item data
    $item = $db->items->findOne(['_id' => $item['_id']]);
}
?>

<h2>Edit Item</h2>

<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
    <label>Code:</label><br>
    <input type="text" value="<?= htmlspecialchars($item['code']) ?>" disabled><br><br>

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" min="0" value="<?= $item['quantity'] ?>" required><br><br>

    <label>Description (optional):</label><br>
    <textarea name="description"><?= htmlspecialchars($item['description'] ?? '') ?></textarea><br><br>

    <button type="submit">Update Item</button>
    <a href="dashboard.php?page=items">
        <button type="button">Cancel</button>
    </a>
</form>
