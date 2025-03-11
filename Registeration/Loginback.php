<?php
session_start();
include("logic.php");

$functions = new Functions($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST["Username"];
    $password = $_POST["Password"];

    $user = $functions->getUserByEmailOrUsername($input);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];

        header("Location: http://localhost/labs/tempphp/Register.html");
        exit();
    } else {
        echo "<script>alert('The Username or Email not Registered in our Website  !'); window.location.href='index.php';</script>";
    }
} else {
    header("Location: index.php");
    exit();
}
