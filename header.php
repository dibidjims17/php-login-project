<?php
// header.php
$current_page = $_GET['page'] ?? 'dashboard';
?>

<header>
    <h2>Inventory System</h2>

    <?php if (isset($_SESSION['username'])): ?>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?> | <a href="logout.php">Logout</a></p>
    <?php endif; ?>

    <ul>
        <?php if (is_admin()): ?>
            <li><a href="dashboard.php?page=add" <?= $current_page === 'add' ? 'style="font-weight:bold;"' : '' ?>>Add Inventory Items</a></li>
        <?php endif; ?>
        <li><a href="dashboard.php?page=view" <?= $current_page === 'view' ? 'style="font-weight:bold;"' : '' ?>>View All Inventory</a></li>
        <li><a href="dashboard.php?page=view" <?= $current_page === 'view' ? 'style="font-weight:bold;"' : '' ?>>View All Inventory2</a></li>
        <li><a href="dashboard.php?page=view" <?= $current_page === 'view' ? 'style="font-weight:bold;"' : '' ?>>View All Inventory3</a></li>
        <li><a href="dashboard.php?page=dashboard" <?= $current_page === 'dashboard' ? 'style="font-weight:bold;"' : '' ?>>Dashboard</a></li>
    </ul>
    <hr>
</header>
