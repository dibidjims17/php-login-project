<?php

protect_page();

if ($_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

// Fetch all users
$users = $db->users->find();
?>

<h2>Users</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= $user['role'] ?></td>
        <td>
            <a href="dashboard.php?page=edit_user&id=<?= $user['_id'] ?>">Edit</a> |
            <a href="dashboard.php?page=delete_user&id=<?= $user['_id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
