<?php
protect_page();

if ($_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

// Fetch all items
$items = $db->items->find();
?>

<h2>Inventory Items</h2>
<a href="dashboard.php?page=add_item">Add New Item</a>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Added By</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['code'] ?? '-') ?></td>
            <td><?= htmlspecialchars($item['name'] ?? '-') ?></td>
            <td><?= htmlspecialchars($item['description'] ?? '-') ?></td>
            <td><?= $item['quantity'] ?? 0 ?></td>
            <td><?= htmlspecialchars($item['added_by'] ?? '-') ?></td>
            <td>
                <a href="dashboard.php?page=edit_item&id=<?= $item['_id'] ?>">Edit</a> |
                <a href="dashboard.php?page=delete_item&id=<?= $item['_id'] ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
