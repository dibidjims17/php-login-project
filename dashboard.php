<?php
require 'config.php';
require 'functions.php';
protect_page(); // only logged-in users

$page = $_GET['page'] ?? 'dashboard';
?>

<?php include 'header.php'; ?>

<div id="content">
<?php
switch ($page) {
    case 'add':
        // Admin-only page
        if (is_admin()) {
            if (file_exists('inventory-add.php')) {
                include 'inventory-add.php';
            } else {
                echo "<p>Inventory add page not available yet.</p>";
            }
        } else {
            echo "<p>Access denied. Admins only.</p>";
        }
        break;

    case 'view':
        if (file_exists('inventory-view.php')) {
            include 'inventory-view.php';
        } else {
            echo "<p>Inventory view page not available yet.</p>";
        }
        break;

    case 'dashboard':
    default:
        echo "<h2>Welcome, " . htmlspecialchars($_SESSION['username']) . "!</h2>";
        echo "<p>You are logged in as <strong>" . ($_SESSION['role'] ?? 'user') . "</strong>.</p>";
        break;
}
?>
</div>

<?php include 'footer.php'; ?>
