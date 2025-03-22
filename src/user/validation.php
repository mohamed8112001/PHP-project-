<?php
session_start(); // Start the session to store the success message
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('blogic.php');function validation($value){
    $value = trim($value);
    $value = htmlspecialchars($value);
    return $value ;
}
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['register'])){
        $errors = [];

        // Sanitize and validate input
        // $name = trim($_POST['name'] ?? '');
        // $email = trim($_POST['email'] ?? '');
        // $password = $_POST['password'] ?? '';
        // $cpassword = $_POST['Cpassword'] ?? '';
        // $room_no = $_POST['room-no'] ?? '';
        // $ext = $_POST['ext'] ?? '';
        // $profile_picture = '';
    
        $name = validation($_POST['name']);
        $Username = validation($_POST['Username']);
        $email = validation($_POST['email']);
        $password = validation($_POST['password'] ?? '');
        $cpassword = validation($_POST['Cpassword'] ?? '');
        $room_no = validation($_POST['room-no'] ?? '');
        $profile_picture = '';
    
        // Name validation
        if (empty($name)) {
            $errors['name'] = 'Name is required.';
        } elseif (strlen($name) < 3) {
            $errors['name'] = 'Name must be at least 3 characters long.';
        }

        if (empty($Username)) {
            $errors['Username'] = 'User Name is required.';
        } elseif (strlen($Username) < 3) {
            $errors['Username'] = 'User Name must be at least 3 characters long.';
        }
    
        // Email validation
        if (empty($email)) {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        }
    
        // Password validation
        if (empty($password)) {
            $errors['password'] = 'Password is required.';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters long.';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $errors['password'] = 'Password must contain at least one uppercase letter.';
        } elseif (!preg_match('/[0-9]/', $password)) {
            $errors['password'] = 'Password must contain at least one number.';
        }
    
        // Confirm password validation
        if ($password !== $cpassword) {
            $errors['cpassword'] = 'Passwords do not match.';
        }
    
        // Room number validation
        if (empty($room_no) || !is_numeric($room_no)) {
            $errors['room_id'] = 'Room number is required and must be a number.';
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
    
            header("Location:adduser.php?errors=".urlencode(json_encode($errors)));
            // foreach ($errors as $error) {
            //     echo "<h3 style='color: red;'>$error</h3>";
            // }
            // exit;
        }
    
       
            $blogic = new User();
            $blogic->insert_user($name, $Username,$email, $password, $profile_picture, $room_no, 'user');
            header("Location:All_Users.php");

    }

//     if(isset($_POST['login'])){
//         $errors = [];
//         var_dump($_POST);
//         // Sanitize and validate input
//         // $name = trim($_POST['name'] ?? '');
//         // $email = trim($_POST['email'] ?? '');
//         // $password = $_POST['password'] ?? '';
//         // $cpassword = $_POST['Cpassword'] ?? '';
//         // $room_no = $_POST['room-no'] ?? '';
//         // $ext = $_POST['ext'] ?? '';
//         // $profile_picture = '';
    
//         // $name = validation($_POST['name']);
//         $email = validation($_POST['email']);
//         $password = validation($_POST['password'] ?? '');
//         // $cpassword = validation($_POST['Cpassword'] ?? '');
//         // $room_no = validation($_POST['room-no'] ?? '');
//         // $profile_picture = '';
    
//         // Name validation
//         // if (empty($name)) {
//         //     $errors['name'] = 'Name is required.';
//         // } elseif (strlen($name) < 3) {
//         //     $errors['name'] = 'Name must be at least 3 characters long.';
//         // }
    
//         // Email validation
//         if (empty($email)) {
//             $errors['name'] = 'Email is required.';
//         } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             $errors['email'] = 'Invalid email format.';
//         }
    
//         // Password validation
//         if (empty($password)) {
//             $errors['password'] = 'Password is required.';
//         } elseif (strlen($password) < 8) {
//             $errors['password'] = 'Password must be at least 8 characters long.';
//         } elseif (!preg_match('/[A-Z]/', $password)) {
//             $errors['password'] = 'Password must contain at least one uppercase letter.';
//         } elseif (!preg_match('/[0-9]/', $password)) {
//             $errors['password'] = 'Password must contain at least one number.';
//         }
    
//         // // Confirm password validation
//         // if ($password !== $cpassword) {
//         //     $errors['cpassword'] = 'Passwords do not match.';
//         // }
    
//         // // Room number validation
//         // if (empty($room_no) || !is_numeric($room_no)) {
//         //     $errors['room_id'] = 'Room number is required and must be a number.';
//         // }
    
    
//         // // Profile picture validation (made optional)
//         // if (isset($_FILES['Profile_Picture']) && $_FILES['Profile_Picture']['error'] == UPLOAD_ERR_OK) {
//         //     $file_tmp = $_FILES['Profile_Picture']['tmp_name'];
//         //     $file_name = basename($_FILES['Profile_Picture']['name']);
//         //     $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
//         //     $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
    
//         //     if (!in_array($file_ext, $allowed_exts)) {
//         //         $errors[] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.';
//         //     } else {
//         //         $file_path = "uploads/" . uniqid() . '.' . $file_ext; // Unique filename
//         //         if (!is_dir('uploads')) {
//         //             mkdir('uploads', 0777, true);
//         //         }
//         //         if (move_uploaded_file($file_tmp, $file_path)) {
//         //             $profile_picture = $file_path;
//         //         } else {
//         //             $errors[] = 'Failed to upload profile picture.';
//         //         }
//         //     }
//         // }
    
//         // If there are errors, display them and stop execution
//         if (!empty($errors)) {
    
//             // header("Location:login.php?errors=".urlencode(json_encode($errors)));
//             // foreach ($errors as $error) {
//             //     echo "<h3 style='color: red;'>$error</h3>";
//             // }
//             // exit;
//         }
    
       
//         $blogic = new User();
// $data = $blogic->login($email, $password);
// var_dump($data);

// sleep(3); // انتظر 3 ثوانٍ قبل التوجيه

// if ($data) {
//     header("Location:adduser.php");
// } else {
//     header("Location:login.php");
// }
// exit();
//             // $_SESSION['success_message'] = "User '$name' registered successfully!";
//             // "<script> alert('add user successfuly')</script>";
//             // exit; 
//     }
    
   
// }
?>
