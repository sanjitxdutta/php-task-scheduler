<?php
require_once __DIR__ . '/functions.php';

if (isset($_GET['email']) && isset($_GET['code'])) {
    $email = urldecode($_GET['email']);
    $code = $_GET['code'];

    $isVerified = verifySubscription($email, $code);
    $message = $isVerified
        ? "✅ Your subscription has been verified. You will now receive task reminders."
        : "❌ Verification failed. Invalid or expired verification code.";
} else {
    $message = "❌ Invalid request. Missing parameters.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>
<body>
    <h1>Email Verification</h1>
    <p><?= htmlspecialchars($message) ?></p>
</body>
</html>
