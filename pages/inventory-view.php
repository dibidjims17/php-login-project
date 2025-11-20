<?php
require '../config.php';
protect_page();
if ($_SESSION['role'] !== 'admin') {
    echo "<p>Access denied. Admins only.</p>";
    return;
}

$items = $items_col->find();
?>

<h3>All Inventory Items</h3>
<table border="1" cellpadding="5">
    <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Description</th>
    </tr>
    <?php foreach ($items as $item): ?>
    <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= $item['quantity'] ?></td>
        <td><?= htmlspecialchars($item['description']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
