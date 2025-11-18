<?php
require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $username = sanitize($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $verification_code = rand(100000, 999999);

    $collection = $db->users;
    $existing = $collection->findOne(['email' => $email]);

    if ($existing) {
        $error = "Email already registered!";
    } else {
        $collection->insertOne([
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => 'user',
            'verified' => false,
            'verification_code' => $verification_code
        ]);

        $success = "Account created! Your verification code is: <strong>$verification_code</strong><br>
                    Redirecting to login in <span id='timer'>5</span> seconds...";
        $redirect = true; // flag to trigger JS countdown later
    }
}
?>

<h2>Inventory System</h2>
<hr>

<h3>Register</h3>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<?php if (empty($success)): ?>
<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Register</button>
    <a href="login.php">
        <button type="button">Back to Login</button>
    </a>
</form>
<?php endif; ?>

<?php if (!empty($redirect)): ?>
<script>
window.onload = function() {
    let seconds = 5;
    const timer = document.getElementById('timer');
    const interval = setInterval(() => {
        seconds--;
        timer.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(interval);
            window.location.href = 'login.php';
        }
    }, 1000);
};
</script>
<?php endif; ?>

<?php include 'footer.php'; ?>
