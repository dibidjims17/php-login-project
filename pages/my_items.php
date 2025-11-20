<?php
protect_page();
if ($_SESSION['role'] !== 'user') {
    die("Access denied. Users only.");
}

$logs = $db->borrows->find(['user_id' => new MongoDB\BSON\ObjectId($_SESSION['user_id'])])->toArray();
?>

<h3>My Borrowed Items</h3>

<?php if (empty($logs)): ?>
    <p>You have no borrow requests.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Requested At</th>
                <th>Status</th>
                <th>Processed By</th>
                <th>Processed At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['item_code'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($log['item_name'] ?? '-') ?></td>
                    <td><?= $log['quantity'] ?? 0 ?></td>
                    <td><?= date('Y-m-d H:i:s', $log['borrowed_at']->toDateTime()->getTimestamp()) ?></td>
                    <td><?= ucfirst($log['status'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($log['processed_by'] ?? '-') ?></td>
                    <td><?= isset($log['processed_at']) ? date('Y-m-d H:i:s', $log['processed_at']->toDateTime()->getTimestamp()) : '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
