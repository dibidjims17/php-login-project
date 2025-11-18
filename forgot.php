<?php
require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);

    $collection = $db->users;
    $user = $collection->findOne(['email' => $email]);

    if (!$user) {
        $error = "Email not found.";
    } else {
        $reset_code = rand(100000, 999999);

        $collection->updateOne(
            ['email' => $email],
            ['$set' => ['reset_code' => $reset_code]]
        );

        $success = "Your reset code is: <strong>$reset_code</strong>";
    }
}
?>

<?php include 'header.php'; ?>

<h3>Forgot Password</h3>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
    <label>Enter your email:</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit">Send Reset Code</button>
</form>

<?php include 'footer.php'; ?>
