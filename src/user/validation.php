<?php
session_start(); // Start the session to store the success message
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('blogic.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Sanitize and validate input
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['Cpassword'] ?? '';
    $room_no = $_POST['room-no'] ?? '';
    $ext = $_POST['ext'] ?? '';
    $profile_picture = '';

    // Name validation
    if (empty($name)) {
        $errors[] = 'Name is required.';
    } elseif (strlen($name) < 3) {
        $errors[] = 'Name must be at least 3 characters long.';
    }

    // Email validation
    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    // Password validation
    if (empty($password)) {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must contain at least one uppercase letter.';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must contain at least one number.';
    }

    // Confirm password validation
    if ($password !== $cpassword) {
        $errors[] = 'Passwords do not match.';
    }

    // Room number validation
    if (empty($room_no) || !is_numeric($room_no)) {
        $errors[] = 'Room number is required and must be a number.';
    }

    // Extension validation (made optional by removing empty check)
    if (!empty($ext) && !is_numeric($ext)) {
        $errors[] = 'Extension must be a number.';
    }

    // Profile picture validation (made optional)
    if (isset($_FILES['Profile_Picture']) && $_FILES['Profile_Picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['Profile_Picture']['tmp_name'];
        $file_name = basename($_FILES['Profile_Picture']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_exts)) {
            $errors[] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.';
        } else {
            $file_path = "uploads/" . uniqid() . '.' . $file_ext; // Unique filename
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }
            if (move_uploaded_file($file_tmp, $file_path)) {
                $profile_picture = $file_path;
            } else {
                $errors[] = 'Failed to upload profile picture.';
            }
        }
    }

    // If there are errors, display them and stop execution
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<h3 style='color: red;'>$error</h3>";
        }
        exit;
    }

   
        $blogic = new User();
        $blogic->insert_user($name, $email, $password, $profile_picture, $room_no, 'user');
        $_SESSION['success_message'] = "User '$name' registered successfully!";
        header("Location:adduser.php");
        exit; 
}
?>
