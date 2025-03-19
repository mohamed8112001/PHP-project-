<?php

require 'mysqlconnection.php';
require 'logic.php';
require 'SMTP.php';

$db = new Query_database($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }
    // make sure the user is in DB
    $user = $db->getUserByEmail($email);
    if (!$user) {
        die("Error: Email not found in database");
    }

    // generate the token for reset pass
    $token = bin2hex(random_bytes(50));
    $resetLink = "http://localhost/labs/tempphp/Reset_Password.html?token=$token";

    // Save the token in DB
    if (!$db->saveResetToken($email, $token)) {
        die("Error: Failed to save reset token.");
    }

    $userName = $user['Username'] ?? 'User';
    if (!SMTP_Config::sendEmail($email, $userName, $resetLink)) {
        die("Error: Failed to send reset email.");
    }
    header("Location: http://localhost/labs/tempphp/Check_Mail_product.php");
} else {
    header("Location: forget_password.html");
    exit();
}
