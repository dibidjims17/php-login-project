<?php
require 'config.php';
require 'functions.php';

// Protect page: only logged-in users can access
protect_page(); // <-- matches config.php

// Check if user is admin
if (!is_admin()) { // <-- matches config.php
    die("Access denied. Admins only.");
}

// Get admin username from session
$username = $_SESSION['username'] ?? 'Admin';
?>

<?php include 'header.php'; ?>

<h2>Admin Panel</h2>

<p>Welcome, Admin <?= htmlspecialchars($username); ?>!</p>

<ul>
    <li><a href="inventory-add.php">Add Inventory Items</a></li>
    <li><a href="inventory-view.php">View All Inventory</a></li>
    <li><a href="dashboard.php">Back to Dashboard</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<?php include 'footer.php'; ?>
