<?php
require 'config.php';
require 'functions.php';
protect_page();

if (!is_admin()) {
    die("Access denied. Admins only.");
}
?>

<?php include 'header.php'; ?>

<h2>Admin Panel</h2>

<p>Welcome, Admin <?= $_SESSION['username']; ?>!</p>

<ul>
    <li><a href="inventory-add.php">Add Inventory Items</a></li>
    <li><a href="inventory-view.php">View All Inventory</a></li>
    <li><a href="dashboard.php">Back to Dashboard</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<?php include 'footer.php'; ?>
