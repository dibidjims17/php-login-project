<?php
require 'config.php';
protect_page();

$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

$query = [];

if ($search !== '') {
    $query = [
        '$or' => [
            ['name' => ['$regex' => $search, '$options' => 'i']],
            ['code' => ['$regex' => $search, '$options' => 'i']]
        ]
    ];
}

$items = $db->items->find($query)->toArray();
?>

<h2>Available Items</h2>

<form method="GET">
    <input type="hidden" name="page" value="user_items">
    <input type="text" name="search" placeholder="Search by name or code" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>

    <?php if (!empty($search)): ?>
        <a href="dashboard.php?page=user_items">Reset</a>
    <?php endif; ?>
</form>


<br>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Description</th>
            <th>Available Qty</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($items)): ?>
            <tr><td colspan="5">No items found.</td></tr>
        <?php else: ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['code']) ?></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['description'] ?? '-') ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>
                        <?php if ($item['quantity'] > 0): ?>
                            <a href="dashboard.php?page=borrow_item&id=<?= $item['_id'] ?>">Borrow</a>
                        <?php else: ?>
                            <span>Out of Stock</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
