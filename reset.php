<?php
require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $code = sanitize($_POST['code']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $collection = $db->users;
    $user = $collection->findOne(['email' => $email]);

    if (!$user) {
        $error = "Email not found.";
    } elseif ($user['reset_code'] != $code) {
        $error = "Invalid reset code.";
    } else {
        // update password
        $collection->updateOne(
            ['email' => $email],
            [
                '$set' => ['password' => $password],
                '$unset' => ['reset_code' => ""]
            ]
        );

        $success = "Password reset successful! You can now log in.";
    }
}
?>

<?php include 'header.php'; ?>

<h3>Reset Password</h3>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Reset Code:</label><br>
    <input type="text" name="code" required><br><br>

    <label>New Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Reset Password</button>
</form>

<?php include 'footer.php'; ?>
