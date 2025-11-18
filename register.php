<?php
require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $username = sanitize($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $verification_code = rand(100000, 999999);

    $collection = $db->users;

    // Check if email already exists
    $existing = $collection->findOne(['email' => $email]);

    if ($existing) {
        $error = "Email already registered!";
    } else {
        // Insert with verification code
        $collection->insertOne([
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'verified' => false,
            'verification_code' => $verification_code
        ]);

        // Normally email is sent — for now we display the code
        $success = "Account created! Your verification code is: <strong>$verification_code</strong>";
    }
}
?>

<?php include 'header.php'; ?>

<h3>Register</h3>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Register</button>
</form>

<?php include 'footer.php'; ?>
