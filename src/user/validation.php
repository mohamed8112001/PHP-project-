<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

include_once('blogic.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {   
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['Cpassword'] ?? '';
    $room_no = $_POST['room-no'] ?? '';
    $ext = $_POST['ext'] ?? '';
    $profile_picture = '';

    $errors = [];

    // ✅ Name Validation
    if (empty($name)) {
        $errors[] = 'Name is required';
    } else {
        $name = htmlspecialchars(trim($name));
    }

    // ✅ Email Validation
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    } else {
        $email = htmlspecialchars(trim($email));
    }

    // ✅ Password Validation
    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters';
    } else {
        $password = trim($password);
    }

    // ✅ Confirm Password Validation
    if (empty($cpassword)) {
        $errors[] = 'Confirm Password is required';
    } elseif ($cpassword !== $password) {
        $errors[] = 'Passwords do not match';
    }

    // ✅ Room No. Validation
    if (empty($room_no)) {
        $errors[] = 'Room No. is required';
    } else {
        $room_no = htmlspecialchars(trim($room_no));
    }

    // ✅ Ext Validation
    if (empty($ext)) {
        $errors[] = 'Ext is required';
    } else {
        $ext = htmlspecialchars(trim($ext));
    }

    // ✅ Profile Picture Upload
    if (isset($_FILES['Profile_Picture']) && $_FILES['Profile_Picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['Profile_Picture']['tmp_name'];
        $file_name = basename($_FILES['Profile_Picture']['name']);
        $file_path = "uploads/" . $file_name;

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($file_tmp, $file_path)) {
            $profile_picture = $file_path;
        } else {
            $errors[] = 'Failed to upload profile picture';
        }
    } else {
        $errors[] = 'Profile picture is required';
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<h3>$error</h3>";
        }
        exit; // Stop execution if errors exist
    }

   
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=mydatabase;charset=utf8", "mohamed", "Mohamed@8112001");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo " Database connected successfully!";
        } catch (PDOException $e) {
            die(" Database connection failed: " . $e->getMessage());
        }
        $blogic = new User();

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $result = $blogic->insert(
            'user',
            ['name', 'email', 'password', 'image_path', 'room_id'],
            [$name, $email, $password_hashed, $profile_picture, $room_no]
        );

        if ($result) {
            echo "<h3>Customer added successfully!</h3>";
        } else {
            echo "<h3>Insert failed.</h3>";
        }

    
} else {
    echo "<h3>No form submitted.</h3>";
}
?>
