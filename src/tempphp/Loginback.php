<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("validation_Login.php");

$validation = new ValidationLogin($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["Username"];
    $password = $_POST["Password"];

    $user = $validation->validateUser($username, $password);

    

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: http://localhost/php_pro/src/Orders/userOrders.php");
        } else {
            header("Location: http://localhost/php_pro/src/addorders/index.php");
        }
        exit();
    } else {
         echo "<script>alert('The Username or Email is Uncorrect!'); window.location.href='index.php';</script>";
    }
} else {
     header("Location: http://localhost/php_pro/src/user/Home.php");
    exit();
}
