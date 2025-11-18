<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inventory System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h2>Inventory System</h2>

    <?php if (isset($_SESSION['username'])): ?>
        <p>Welcome, <?php echo $_SESSION['username']; ?> | <a href="logout.php">Logout</a></p>
    <?php endif; ?>
</header>

<hr>
