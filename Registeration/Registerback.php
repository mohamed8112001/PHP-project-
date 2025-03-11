<?php
include("Validation.php");
include("logic.php");

try {
    $functions = new Functions($pdo);

    $Username   = $_POST['Username'] ?? '';
    $Email      = $_POST['Email'] ?? '';
    $Password   = $_POST['Password'] ?? '';
    $First_name = $_POST['First_name'] ?? '';
    $Last_name  = $_POST['Last_name'] ?? '';
    $phone      = $_POST['phone'] ?? '';
    $Gender     = $_POST['Gender'] ?? 'User';
    $profile_image = "default.jpg";

    ValidationRegister::UserName($Username);
    ValidationRegister::Email($Email);
    ValidationRegister::Password($Password);
    ValidationRegister::FirstName($First_name);
    ValidationRegister::LastName($Last_name);
    ValidationRegister::Phone($phone);
    ValidationRegister::Gender($Gender);

    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
        $target_dir  = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name   = uniqid() . "_" . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (!move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            throw new Exception('Failed to upload profile image.');
        }

        $profile_image = $target_file;
    }

    $hashedPassword = password_hash($Password, PASSWORD_BCRYPT);

    $data = [
        'Username' => $Username,
        'Email' => $Email,
        'password_hash' => $hashedPassword,
        'First_name' => $First_name,
        'Last_name' => $Last_name,
        'Phone_number' => $phone,
        'Gender' => $Gender,
        'profile_image' => $profile_image
    ];

    $result = $functions->insertData('User', $data);

    if ($result === true) {
        header("Location: http://localhost/labs/tempphp/Login.html");
        exit;
    } else {
        die("Error inserting data: " . $result);
    }
} catch (Exception $e) {
    echo "<script>alert('" . $e->getMessage() . "'); window.history.back();</script>";
    exit;
}
