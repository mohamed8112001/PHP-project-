<?php
session_start(); // Start session for potential future use
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('blogic.php');
include_once('templates/navbar.php');

$success_message = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Extension validation (optional)
    if (!empty($ext) && !is_numeric($ext)) {
        $errors[] = 'Extension must be a number.';
    }

    // Profile picture validation (optional)
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

    // If there are errors, store them for display
    if (!empty($errors)) {
        // Errors will be shown in the form below
    } else {
        // Insert the user into the database
        try {
            $blogic = new User();
            $blogic->insert_user($name, $email, $password, $profile_picture, $room_no, 'user');
            $success_message = "User '$name' registered successfully! Redirecting to dashboard...";
            // No immediate header redirect here; we'll use JavaScript below
        } catch (Exception $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}

$blogic = new User(); // For fetching rooms in the form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="templates/stylee.css">
</head>
<body>
    <?php include('templates/navbar.php'); ?>

    <div class="page-container">
    <form action="validation.php" method="post" enctype="multipart/form-data" id="registrationForm">
            <div class="form-header">Add New User</div>

            <?php
            if (!empty($success_message)) {
                echo "<div class='success-message'>$success_message</div>";
                echo "<script>
                        setTimeout(() => {
                            window.location.href = 'index.php'; // Redirect to dashboard, not self
                        }, 2000);
                      </script>";
            }

            if (!empty($errors)) {
                echo "<div class='error-container'>";
                foreach ($errors as $error) {
                    echo "<p class='error-message'>$error</p>";
                }
                echo "</div>";
            }
            ?>

            <div class="form-group">
                <label for="name">Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" placeholder="Enter your name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required aria-describedby="name-error">
                <span class="error" id="name-error"></span>
            </div>

            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required aria-describedby="email-error">
                <span class="error" id="email-error"></span>
            </div>

            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Enter your password" required aria-describedby="password-error">
                    <button type="button" class="toggle-password" aria-label="Toggle password visibility">👁️</button>
                </div>
                <span class="error" id="password-error"></span>
            </div>

            <div class="form-group">
                <label for="Cpassword">Confirm Password <span class="required">*</span></label>
                <div class="password-wrapper">
                    <input type="password" name="Cpassword" id="Cpassword" placeholder="Confirm your password" required aria-describedby="cpassword-error">
                    <button type="button" class="toggle-password" aria-label="Toggle password visibility">👁️</button>
                </div>
                <span class="error" id="cpassword-error"></span>
            </div>

            <div class="form-group">
                <label for="room-no">Room No. <span class="required">*</span></label>
                <select name="room-no" id="room-no" required aria-describedby="room-error">
                    <option value="" disabled <?php echo empty($room_no) ? 'selected' : ''; ?>>Select a room</option>
                    <?php
                    $rooms = $blogic->getAllRooms();
                    if (!empty($rooms) && is_array($rooms)) {
                        foreach ($rooms as $room) {
                            $selected = ($room_no == $room['id']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($room['id']) . "' $selected>" . htmlspecialchars($room['number']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No rooms available</option>";
                    }
                    ?>
                </select>
                <span class="error" id="room-error"></span>
            </div>

            <div class="form-group">
                <label for="Profile_Picture">Profile Picture</label>
                <input type="file" name="Profile_Picture" id="Profile_Picture" accept="image/*" aria-describedby="file-error">
                <span class="error" id="file-error"></span>
            </div>

            <div class="button-group">
                <input type="submit" name="send" value="Add User">
            </div>
        </form>
    </div>

    <script>
        // Navbar Toggle
        const mobileMenu = document.getElementById('mobile-menu');
        const navMenu = document.querySelector('.nav-menu');
        mobileMenu.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Dynamic Navbar Background on Scroll
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        

        // Client-side Validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            let isValid = true;
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const cpassword = document.getElementById('Cpassword').value;
            const room = document.getElementById('room-no').value;
            const file = document.getElementById('Profile_Picture').files[0];

            document.querySelectorAll('.error').forEach(error => error.textContent = '');

            if (name.length < 3) {
                document.getElementById('name-error').textContent = 'Name must be at least 3 characters.';
                isValid = false;
            }

            if (!email.includes('@') || !email.includes('.')) {
                document.getElementById('email-error').textContent = 'Invalid email format.';
                isValid = false;
            }

            if (password.length < 8) {
                document.getElementById('password-error').textContent = 'Password must be at least 8 characters.';
                isValid = false;
            } else if (!/[A-Z]/.test(password)) {
                document.getElementById('password-error').textContent = 'Password must contain an uppercase letter.';
                isValid = false;
            } else if (!/[0-9]/.test(password)) {
                document.getElementById('password-error').textContent = 'Password must contain a number.';
                isValid = false;
            }

            if (password !== cpassword) {
                document.getElementById('cpassword-error').textContent = 'Passwords do not match.';
                isValid = false;
            }

            if (!room) {
                document.getElementById('room-error').textContent = 'Please select a room.';
                isValid = false;
            }

            if (file && !['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                document.getElementById('file-error').textContent = 'Only JPG, PNG, or GIF allowed.';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Toggle Password Visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', () => {
                const input = button.previousElementSibling;
                input.type = input.type === 'password' ? 'text' : 'password';
                button.textContent = input.type === 'password' ? '👁️' : '🙈';
            });
        });
    </script>


    </div>

   
</body>
</html>