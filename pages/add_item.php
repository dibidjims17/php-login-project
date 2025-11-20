<?php
require 'config.php';
protect_page();

if ($_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $quantity = (int)$_POST['quantity'];
    $description = sanitize($_POST['description'] ?? '');
    $added_by = $_SESSION['username'];

    // Generate unique code
    $lastItem = $db->items->find([], ['sort' => ['_id' => -1], 'limit' => 1])->toArray();
    if (!empty($lastItem) && isset($lastItem[0]['code'])) {
        $lastCode = $lastItem[0]['code'];
        $num = (int)substr($lastCode, 3); // remove 'ITM' prefix
        $newCode = 'ITM' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newCode = 'ITM001';
    }

    // Insert into MongoDB
    $db->items->insertOne([
        'code' => $newCode,
        'name' => $name,
        'quantity' => $quantity,
        'description' => $description,
        'added_by' => $added_by
    ]);

    $success = "Item <strong>$name</strong> added with Code <strong>$newCode</strong>.";
}
?>

<h2>Add New Item</h2>

<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" min="1" required><br><br>

    <label>Description (optional):</label><br>
    <textarea name="description"></textarea><br><br>

    <button type="submit">Add Item</button>
    <a href="dashboard.php?page=items">
        <button type="button">Cancel</button>
    </a>
</form>
