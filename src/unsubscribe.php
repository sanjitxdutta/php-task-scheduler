<?php
require_once __DIR__ . '/functions.php';

if (isset($_GET['email'])) {
    $email = urldecode($_GET['email']);
    unsubscribeEmail($email);
    $message = "You have been unsubscribed successfully.";
} else {
    $message = "Invalid unsubscribe request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unsubscribe</title>
</head>
<body>
    <h1>Unsubscribe</h1>
    <p><?= htmlspecialchars($message) ?></p>
</body>
</html>
