<?php
require 'config.php';
require 'functions.php';
protect_page(); // only logged-in users can access
?>

<?php include 'header.php'; ?>

<h2>Welcome, <?= $_SESSION['username']; ?>!</h2>

<p>You are logged in.</p>

<ul>
    <li><a href="inventory-view.php">View Inventory</a></li>
    <li><a href="inventory-add.php">Add Items (if admin)</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<?php include 'footer.php'; ?>
