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

    
    session_start(); 
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['image_path'] = $user['image_path'];
        

        if ($user['role'] === 'admin' ) {
            header("Location: http://localhost/PHP/src/Orders/userOrders.php");
        }else if($user['role'] === 'user') {
            // header("Location: http://localhost/PHP/src/addorders/index.php");
            header("Location: http://localhost/PHP/src/Orders/userOrders.php");
        }
        exit();
    } else {
         echo "<script>alert('The Username and or Email is Uncorrect!'); window.location.href='index.php';</script>";
    }
}
//  else {
//     //  header("Location: http://localhost/PHP/src/user/Home.php");
//     exit();
// }
