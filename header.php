<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'config.php';
require 'functions.php';

protect_page(); // Only logged-in users

// Fetch user info from session
$username = $_SESSION['username'] ?? 'User';
$role = $_SESSION['role'] ?? 'user';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Joyson Warehouse</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .nav { background: #333; padding: 10px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .nav a:hover { text-decoration: underline; }
        .nav span { color: white; margin-right: 20px; }
        .nav-right { float: right; }
    </style>
</head>
<body>

<div class="nav">
    <span>Hello, <?= htmlspecialchars($username) ?></span>

    <a href="dashboard.php?page=home">Dashboard</a>

    <?php if ($role === 'admin'): ?>
        <a href="dashboard.php?page=items">Manage Items</a>
        <a href="dashboard.php?page=borrow_log">Borrow Log</a>
        <a href="dashboard.php?page=users">Users</a>
    <?php else: ?>
        <a href="dashboard.php?page=user_items">Items</a>
        <a href="dashboard.php?page=my_items">My Borrowed Items</a>
    <?php endif; ?>

    <span class="nav-right"><a href="logout.php">Logout</a></span>
</div>

<hr>
