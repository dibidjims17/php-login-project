<?php
require 'config.php';
require 'functions.php';

use MongoDB\BSON\UTCDateTime;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $reset_code = sanitize($_POST['reset_code']);
    $new_password = $_POST['new_password'];
    $collection = $db->users;

    $user = $collection->findOne(['email' => $email, 'reset_code' => (int)$reset_code]);

    if (!$user) {
        $error = "Invalid email or reset code.";
    } else {
        // Check expiration
        $expires = $user['reset_code_expires'] ?? null;

        if ($expires && $expires instanceof UTCDateTime) {
            $expires_timestamp = (int)($expires->toDateTime()->format('U'));
            if (time() > $expires_timestamp) {
                $error = "Reset code has expired. Please request a new one.";
            }
        }

        if (empty($error)) {
            // Update password and remove reset code
            $collection->updateOne(
                ['email' => $email],
                ['$set' => ['password' => password_hash($new_password, PASSWORD_DEFAULT)],
                 '$unset' => ['reset_code' => '', 'reset_code_expires' => '']]
            );

            $success = "Password has been reset successfully! <a href='login.php'>Login here</a>";
        }
    }
}
?>

<h2>Inventory System</h2>
<hr>

<h3>Reset Password</h3>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Reset Code:</label><br>
    <input type="text" name="reset_code" required><br><br>

    <label>New Password:</label><br>
    <input type="password" name="new_password" required><br><br>

    <button type="submit">Reset Password</button>
    <a href="forgot.php">
        <button type="button">Back</button>
    </a>
</form>

<?php include 'footer.php'; ?>
