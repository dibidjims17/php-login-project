<?php
require 'config.php';
require 'functions.php';

use MongoDB\BSON\UTCDateTime;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $collection = $db->users;
    $user = $collection->findOne(['email' => $email]);

    if (!$user) {
        $error = "Email not found.";
    } else {
        // Generate 6-digit reset code
        $reset_code = rand(100000, 999999);

        // Expiration: 15 minutes from now
        $expires = new UTCDateTime((time() + 15*60) * 1000);

        // Update user document
        $collection->updateOne(
            ['email' => $email],
            ['$set' => [
                'reset_code' => $reset_code,
                'reset_code_expires' => $expires
            ]]
        );

        // For now, display code. In production, send email
        $success = "Your reset code is: <strong>$reset_code</strong>";
    }
}
?>

<h2>Inventory System</h2>
<hr>

<h3>Forgot Password</h3>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
    <label>Enter your email:</label><br>
    <input type="email" name="email" required><br><br>
    <button type="submit">Send Reset Code</button>
    <a href="login.php">
        <button type="button">Back</button>
    </a>
</form>

<p>Already have a reset code? <a href="reset.php">Reset Password</a></p>

<?php include 'footer.php'; ?>
