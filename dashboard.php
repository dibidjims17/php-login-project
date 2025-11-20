<?php
require 'config.php';
require 'functions.php';
protect_page(); // Must be logged in

$page = $_GET['page'] ?? 'home';

include 'header.php';
?>

<div id="content">
<?php

switch ($page) {

    // -------------------------------------------------------
    // USER PAGES
    // -------------------------------------------------------

    case 'user_items':  // <-- NEW
        if ($_SESSION['role'] === 'user') {
            include 'pages/user_items.php';
        } else {
            echo "<p>Access denied. Users only.</p>";
        }
        break;

    case 'borrow_item': // <-- NEW
        if ($_SESSION['role'] === 'user') {
            include 'pages/borrow_item.php';
        } else {
            echo "<p>Access denied. Users only.</p>";
        }
        break;

    case 'my_items':
        if ($_SESSION['role'] === 'user') {
            include 'pages/my_items.php';
        } else {
            echo "<p>Access denied. Users only.</p>";
        }
        break;



    // -------------------------------------------------------
    // ADMIN PAGES
    // -------------------------------------------------------

    case 'items':
        if ($_SESSION['role'] === 'admin') {
            include 'pages/items.php';
        } else {
            echo "<p>Access denied. Admins only.</p>";
        }
        break;

    case 'add_item':
        if ($_SESSION['role'] === 'admin') {
            include 'pages/add_item.php';
        } else {
            echo "<p>Access denied. Admins only.</p>";
        }
        break;

    case 'edit_item':
        if ($_SESSION['role'] === 'admin') {
            include 'pages/edit_item.php';
        } else {
            echo "<p>Access denied. Admins only.</p>";
        }
        break;

    case 'delete_item':
        if ($_SESSION['role'] === 'admin') {
            include 'pages/delete_item.php';
        } else {
            echo "<p>Access denied. Admins only.</p>";
        }
        break;

    case 'borrow_log':
        if ($_SESSION['role'] === 'admin') {
            include 'pages/borrow_log.php';
        } else {
            echo "<p>Access denied. Admins only.</p>";
        }
        break;

    case 'users':
        if ($_SESSION['role'] === 'admin') {
            include 'pages/users.php';
        } else {
            echo "<p>Access denied. Admins only.</p>";
        }
        break;



    // -------------------------------------------------------
    // HOME PAGE
    // -------------------------------------------------------

    case 'home':
    default:
        echo "<h2>Welcome, " . htmlspecialchars($_SESSION['username']) . "!</h2>";
        echo "<p>You are logged in as <strong>" . ($_SESSION['role'] ?? 'user') . "</strong>.</p>";
        break;
}

?>
</div>

<?php include 'footer.php'; ?>
