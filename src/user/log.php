<?php

include("mysqlconnection.php");
include("insert.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username       = $_POST['Username'] ?? '';
    $Email          = $_POST['email'] ?? '';
    $Password       = $_POST['Password'] ?? '';
    $First_name     = $_POST['First_name'] ?? '';
    $Last_name      = $_POST['Last_name'] ?? '';
    $phone          = $_POST['phone'] ?? '';
    $profile_image  = "default.jpg";
    $Gender         = $_POST['Gender'] ?? '';
    $Role           = $_POST['Role'] ?? 'User';

    if (!in_array($Gender, ['Male', 'Female'])) {
        echo "<script>alert('Please select a valid gender'); window.history.back();</script>";
        exit;
    }
    if (!isset($_POST['Email']) || empty(trim($_POST['Email']))) {
        echo "<script>alert('Email field is empty'); window.history.back();</script>";
        exit;
    }

    $Email = trim(strtolower($_POST['Email']));
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid Email Format: " . addslashes($Email) . "'); window.history.back();</script>";
        exit;
    }


    if (!preg_match('/^[0-9]{10,25}$/', $phone)) {
        echo "<script>alert('Invalid Phone number')</script>";
        exit;
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM User WHERE Username = :Username OR email = :Email");
    $stmt->execute([':Username' => $Username, ':Email' => $Email]);
    if ($stmt->fetchColumn() > 0) {
        echo "<script>alert('The user is used or the Email is used')</script>";
        exit;
    }

    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
        $target_dir  = "uploads/";
        $file_name   = basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png"];

        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Only JPG, JPEG, and PNG files are allowed.'); window.history.back();</script>";
            exit;
        }

        if ($_FILES["profile_image"]["size"] > 10 * 1024 * 1024) {
            echo "<script>alert('Image size must be less than 2MB.'); window.history.back();</script>";
            exit;
        }

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $profile_image = $target_file;
        } else {
            echo "<script>alert('Failed to upload profile image. Using default image.');</script>";
        }
    }

    if (!empty($Username) && !empty($Email) && !empty($Password) && !empty($First_name) && !empty($Last_name) && !empty($phone) && !empty($profile_image) && !empty($Gender)) {
        $result = Register($Username, $Email, $Password, $First_name, $Last_name, $phone, $profile_image, $Gender, $Role = 'User');

        if ($result === true) {
            echo "<script>alert('Registration successful'); window.location.href = 'index.php';</script>";
            header("Location: http://localhost/labs/prooojectphp/Login.html");
        } else {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
            echo "<script>alert('Try again. Error: " . addslashes($result) . "');</script>";
        }
    } else {
        echo "<script>alert('Fill in all the required inputs');</script>";
    }
} else {
    echo "<script>alert('Invalid request method'); window.history.back();</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    a
    <link rel="stylesheet" href="register.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Add User</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <h1>Welcome to TechnoZone</h1>
    </header>
    <main>
        <div class="container_form">
            <form method="POST" action="Registerback.php" enctype="multipart/form-data">
                <label for="Username">Username</label>
                <input type="text" name="Username" required>

                <label for="Email">Email</label>
                <input type="email" name="Email" required>

                <label for="Password">Password</label>
                <input type="Password" name="Password" required>

                <label for="First_name">Firstname</label>
                <input type="text" name="First_name">

                <label for="Last_name">LastName</label>
                <input type="text" name="Last_name">


                <label for="phone">Phone Number</label>
                <input type="text" name="phone">

                <label for="Gender">Gender</label>
                <select id="Gender" name="Gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <label for="profile_image">Profile image</label>
                <input id="image" type="file" name="profile_image" required>

                <input type="hidden" name="Role" value="User">
                <button type="submit">Register</button>

            </form>
        </div>
    </main>
    <footer>
        <p>All copy right is abroved &COPY;</p>
    </footer>

</body>

</html>