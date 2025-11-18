<?php
require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $collection = $db->users;
    $user = $collection->findOne(['email' => $email]);

    if (!$user) {
        $error = "Email not found.";
    } elseif (!$user['verified']) {
        $error = "Account not verified.";
    } elseif (!password_verify($password, $user['password'])) {
        $error = "Incorrect password.";
    } else {
        // Login success
        $_SESSION['user_id'] = (string) $user['_id'];
        $_SESSION['username'] = $user['username'];

        redirect("dashboard.php");
    }
}
?>

<?php include 'header.php'; ?>

<h3>Login</h3>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<p><a href="forgot.php">Forgot password?</a></p>

<?php include 'footer.php'; ?>
