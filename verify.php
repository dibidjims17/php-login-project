<?php
require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $code = sanitize($_POST['code']);

    $collection = $db->users;

    $user = $collection->findOne(['email' => $email]);

    if (!$user) {
        $error = "Email not found.";
    } elseif ($user['verification_code'] != $code) {
        $error = "Invalid verification code.";
    } else {
        // Mark verified
        $collection->updateOne(
            ['email' => $email],
            ['$set' => ['verified' => true], '$unset' => ['verification_code' => ""]]
        );

        $success = "Account verified! You can now log in.";
    }
}
?>

<?php include 'header.php'; ?>

<h3>Verify Account</h3>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Verification Code:</label><br>
    <input type="text" name="code" required><br><br>

    <button type="submit">Verify</button>
</form>

<?php include 'footer.php'; ?>
