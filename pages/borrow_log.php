<?php
protect_page();
if ($_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

// Handle approve/reject actions
if (isset($_GET['action'], $_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action']; // approve or reject
    $borrow = $db->borrows->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

    if ($borrow && $borrow['status'] === 'pending') {
        if ($action === 'approve') {
            // Reduce item quantity
            $db->items->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($borrow['item_id'])],
                ['$inc' => ['quantity' => -$borrow['quantity']]]
            );
            $status = 'approved';
        } elseif ($action === 'reject') {
            $status = 'rejected';
        }

        $db->borrows->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => [
                'status' => $status,
                'processed_at' => new MongoDB\BSON\UTCDateTime(),
                'processed_by' => $_SESSION['username']
            ]]
        );
    }

    header('Location: dashboard.php?page=borrow_log');
    exit;
}

// Fetch all borrow requests (optional search by username or item)
$searchQuery = $_GET['q'] ?? '';
$query = [];
if (!empty($searchQuery)) {
    $query['$or'] = [
        ['username' => ['$regex' => $searchQuery, '$options' => 'i']],
        ['email' => ['$regex' => $searchQuery, '$options' => 'i']],
        ['item_name' => ['$regex' => $searchQuery, '$options' => 'i']],
        ['item_code' => ['$regex' => $searchQuery, '$options' => 'i']]
    ];
}
$logs = $db->borrows->find($query)->toArray();
?>

<h3>Borrow Logs (Admin)</h3>

<form method="GET" style="margin-bottom: 20px;">
    <input type="hidden" name="page" value="borrow_log">
    <label>Search:</label>
    <input type="text" name="q" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Username, email, item, or code">
    <button type="submit">Search</button>
    <?php if (!empty($searchQuery)): ?>
        <a href="dashboard.php?page=borrow_log">Reset</a>
    <?php endif; ?>
</form>

<?php if (empty($logs)): ?>
    <p>No borrow logs found.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Requested At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['username'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($log['email'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($log['item_code'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($log['item_name'] ?? '-') ?></td>
                    <td><?= $log['quantity'] ?? 0 ?></td>
                    <td><?= date('Y-m-d H:i:s', $log['borrowed_at']->toDateTime()->getTimestamp()) ?></td>
                    <td><?= ucfirst($log['status'] ?? '-') ?></td>
                    <td>
                        <?php if ($log['status'] === 'pending'): ?>
                            <a href="dashboard.php?page=borrow_log&id=<?= $log['_id'] ?>&action=approve">Approve</a> |
                            <a href="dashboard.php?page=borrow_log&id=<?= $log['_id'] ?>&action=reject">Reject</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
