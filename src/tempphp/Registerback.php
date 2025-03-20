<?php
include_once("Validation_Register.php");
include_once("logic.php");
include_once("SMTP.php");
try {
    $functions = new Query_database($pdo);
    $rooms = $functions->getAllRooms();
    ValidationRegister::setDatabaseConnection($pdo);



    $Username       = $_POST['Username'] ?? '';
    $Email          = $_POST['Email'] ?? '';
    $Password       = $_POST['Password'] ?? '';
    $First_name     = $_POST['First_name'] ?? '';
    // $Last_name   = $_POST['Last_name'] ?? '';
    // $phone       = $_POST['phone'] ?? '';
    // $Gender      = $_POST['Gender'] ?? 'User';
    $Role           = $_POST['Role'] ?? 'User';
    $room_id        = $_POST['room_id'];

    // ✅ التأكد من أن room_id المرسل موجود في القائمة
    if (!in_array($room_id, $valid_room_ids)) {
        throw new Exception("Invalid Room ID selected.");
    }

    $profile_image = "default.jpg";

    ValidationRegister::Username($Username);
    ValidationRegister::Email($Email);
    ValidationRegister::Password($Password);
    ValidationRegister::FirstName($First_name);
    // ValidationRegister::LastName($Last_name);
    // ValidationRegister::Phone($phone);
    // ValidationRegister::Gender($Gender);
    ValidationRegister::RoomID($room_id);
    ValidationRegister::Role($Role);

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
    $verification_token = bin2hex(random_bytes(50));

    $data = [
        'Username'              => $Username,
        'email'                 => $Email,
        'password'               => $hashedPassword,
        'name'                  => $First_name,
        // 'Last_name'             => $Last_name,
        // 'Phone_number'          => $phone,
        // 'gender'                => $Gender,
        'role'                  => $Role,
        'image_path'            => $profile_image,
        'room_id'               => $room_id,
        'is_verified'           => 0,
        'verification_token'    => $verification_token
    ];


    $result = $functions->insertData('user', $data);

    if ($result === true) {
        $verification_link = "http://localhost/labs/tempphp/Login.html?token=" . $verification_token;
        $subject = "Confirm Your Account";
        $message = "Hello $Username,<br> Click the following link to verify your account:<br> 
                    <a href='$verification_link'>$verification_link</a>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@yourwebsite.com" . "\r\n";

        if (SMTP_Config::sendEmail($Email, $Username, $verification_link)) {
            header("Location: http://localhost/labs/tempphp/Check_Mail_product.php");
        } else {
            throw new Exception("Failed to send verification email.");
        }

        exit;
    } else {
        die("Error inserting data: " . $result);
    }
} catch (Exception $e) {
    echo "<script>alert('" . $e->getMessage() . "'); window.history.back();</script>";
    exit;
}
