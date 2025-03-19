<?php
session_start();
include("validation_Login.php");

$validation = new ValidationLogin($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["Username"];
    $password = $_POST["Password"];

    $user = $validation->validateUser($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];

        if ($user['Role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: make_order.php");
        }
        exit();
    } else {
        echo "<script>alert('The Username or Email is Uncorrect!'); window.location.href='index.php';</script>";
    }
} else {
    header("Location: index.php");
    exit();
}
