<?php
require 'mysqlconnection.php';
require 'logic.php';

$db = new Query_database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        die("Error: Passwords do not match.");
    }

    $email = $db->getEmailByToken($token);
    if (!$email) {
        die("Error: Invalid or expired token.");
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    if (!$db->updatePassword($email, $hashedPassword)) {
        die("Error: Failed to update password.");
    }

    echo "Password has been reset successfully.";
} else {
    header("Location: Reset_Password.html");
    exit();
}
