<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('blogic.php');
$errors = [];

if (isset($_GET['errors'])) {
    $errors = json_decode($_GET['errors'], true);
}
$blogic = new User();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - PHP CoffeeCenter</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../template/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="stylee.css">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #2c3e50;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /* Card Styling */
        .card {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 580px;
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        .card-header {
            color: white;
            padding: 25px 30px;
            position: relative;
        }

        .card-header h2 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            text-align: center;
        }

        .card-body {
            padding: 30px;
        }

        /* Form Styling */
        .admin-form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 15px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .required {
            color: #e74c3c;
            margin-left: 5px;
        }

        input,
        select {
            padding: 14px;
            border: 1px solid #e0e6ed;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #fafafa;
            outline: none;
        }

        input:focus,
        select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            background-color: #fff;
        }

        /* Password Styling */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            color: #95a5a6;
            font-size: 18px;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            width: 40px;
        }

        .toggle-password:hover {
            color: #3498db;
        }

        /* Error Styling */
        .error {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Success Message */
        .success-message {
            background-color: #2ecc71;
            color: #ffffff;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .success-message i {
            font-size: 20px;
        }

        /* File Input */
        .file-input-wrapper {
            position: relative;
        }

        input[type="file"] {
            border: 1px dashed #bdc3c7;
            background-color: #f8f9fa;
            padding: 16px;
            text-align: center;
            cursor: pointer;
        }

        input[type="file"]:hover {
            background-color: #f0f3f6;
        }

        /* Button Styling */
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .btn {
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            flex: 1;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
        }

        .btn-primary {
            background-color: #3498db;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-danger {
            background-color: #e74c3c;
            color: #ffffff;
            text-decoration: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .card-header {
                padding: 20px;
            }
            
            .card-header h2 {
                font-size: 22px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            input, select, .btn {
                padding: 12px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?php include_once('../template/nav.php'); ?>

        <div class="content-wrapper">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-user-plus"></i> Add New User</h2>
                    
                </div>
                <div class="card-body">
                    <?php
                    if (!empty($success_message)) {
                        echo "<div class='success-message'><i class='fas fa-check-circle'></i> $success_message</div>";
                        echo "<script>setTimeout(() => { window.location.href = 'index.php'; }, 2000);</script>";
                    }
                    ?>

                    <form action="validation.php" method="post" enctype="multipart/form-data" id="registrationForm" class="admin-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Name <span class="required">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Enter your name" required>
                                <?php
                                if (isset($errors['name'])) {
                                    echo "<span class='error'><i class='fas fa-exclamation-circle'></i> " . $errors['name'] . "</span>";
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="Username">Username <span class="required">*</span></label>
                                <input type="text" name="Username" id="Username" placeholder="Enter your username" required>
                                <?php
                                if (isset($errors['Username'])) {
                                    echo "<span class='error'><i class='fas fa-exclamation-circle'></i> " . $errors['Username'] . "</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" name="email" id="email" placeholder="Enter your email address" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                            <span id="email-error" class="error"></span>
                            <?php
                            if (isset($errors['email'])) {
                                echo "<span class='error'><i class='fas fa-exclamation-circle'></i> " . $errors['email'] . "</span>";
                            }
                            ?>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password <span class="required">*</span></label>
                                <div class="password-wrapper">
                                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                                    <button type="button" class="toggle-password" aria-label="Toggle password visibility"><i class="fas fa-eye"></i></button>
                                </div>
                                <span id="password-error" class="error"></span>
                                <?php
                                if (isset($errors['password'])) {
                                    echo "<span class='error'><i class='fas fa-exclamation-circle'></i> " . $errors['password'] . "</span>";
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="Cpassword">Confirm Password <span class="required">*</span></label>
                                <div class="password-wrapper">
                                    <input type="password" name="Cpassword" id="Cpassword" placeholder="Confirm your password" required>
                                    <button type="button" class="toggle-password" aria-label="Toggle password visibility"><i class="fas fa-eye"></i></button>
                                </div>
                                <span id="cpassword-error" class="error"></span>
                                <?php
                                if (isset($errors['Cpassword'])) {
                                    echo "<span class='error'><i class='fas fa-exclamation-circle'></i> " . $errors['Cpassword'] . "</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="room-no">Room Number <span class="required">*</span></label>
                                <select name="room-no" id="room-no" required>
                                    <option value="" disabled selected>Select a room</option>
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
                                <span id="room-error" class="error"></span>
                                <?php
                                if (isset($errors['room_id'])) {
                                    echo "<span class='error'><i class='fas fa-exclamation-circle'></i> " . $errors['room_id'] . "</span>";
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="Profile_Picture">Profile Picture</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="Profile_Picture" id="Profile_Picture" accept="image/*">
                                </div>
                                <span id="file-error" class="error"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="user-type">Room Number <span class="required">*</span></label>
                                <select name="user-type" id="user-type" required>
                                    <option value='admin' $selected>admin</option>
                                    <option value='user' $selected>user</option>
                                </select>
                                <span id="room-error" class="error"></span>
                                <?php
                                if (isset($errors['uType-error'])) {
                                    echo "<span class='error'><i class='fas fa-exclamation-circle'></i> " . $errors['uType-error'] . "</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="button-group">
                            <button type="submit" name="register" class="btn btn-primary"><i class="fas fa-save"></i> Add User</button>
                            <a href="Home.php" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include_once('../template/footer.php'); ?>
    </div>

    <script>
        // Navbar Toggle
        const mobileMenu = document.getElementById('mobile-menu');
        const navMenu = document.querySelector('.nav-menu');
        if (mobileMenu && navMenu) {
            mobileMenu.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
                navMenu.classList.toggle('active');
            });
        }

        // Dynamic Navbar Background on Scroll
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.admin-navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });

        // Client-side Validation
        document.getElementById('registrationForm').addEventListener('submit', function (e) {
            let isValid = true;
            const name = document.getElementById('name').value.trim();
            const username = document.getElementById('Username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const cpassword = document.getElementById('Cpassword').value;
            const room = document.getElementById('room-no').value;
            const uType = document.getElementById('user-type').value;
            const file = document.getElementById('Profile_Picture').files[0];

            // Clear previous error messages
            document.querySelectorAll('.error').forEach(error => error.innerHTML = '');

            // Validate name
            if (name === '') {
                document.getElementById('name').nextElementSibling.innerHTML = '<i class="fas fa-exclamation-circle"></i> Name is required';
                isValid = false;
            }

            // Validate username
            if (username === '') {
                document.getElementById('Username').nextElementSibling.innerHTML = '<i class="fas fa-exclamation-circle"></i> Username is required';
                isValid = false;
            }

            // Validate email
            if (!email.includes('@') || !email.includes('.')) {
                document.getElementById('email-error').innerHTML = '<i class="fas fa-exclamation-circle"></i> Invalid email format';
                isValid = false;
            }

            // Validate password
            if (password.length < 8) {
                document.getElementById('password-error').innerHTML = '<i class="fas fa-exclamation-circle"></i> Password must be at least 8 characters';
                isValid = false;
            } else if (!/[A-Z]/.test(password)) {
                document.getElementById('password-error').innerHTML = '<i class="fas fa-exclamation-circle"></i> Password must contain an uppercase letter';
                isValid = false;
            } else if (!/[0-9]/.test(password)) {
                document.getElementById('password-error').innerHTML = '<i class="fas fa-exclamation-circle"></i> Password must contain a number';
                isValid = false;
            }

            // Validate password confirmation
            if (password !== cpassword) {
                document.getElementById('cpassword-error').innerHTML = '<i class="fas fa-exclamation-circle"></i> Passwords do not match';
                isValid = false;
            }

            // Validate room selection
            if (!room) {
                document.getElementById('room-error').innerHTML = '<i class="fas fa-exclamation-circle"></i> Please select a room';
                isValid = false;
            }
            if (!uType) {
                document.getElementById('uType-error').innerHTML = '<i class="fas fa-exclamation-circle"></i> Please select user type';
                isValid = false;
            }

            // Validate file type if a file is selected
            if (file && !['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                document.getElementById('file-error').innerHTML = '<i class="fas fa-exclamation-circle"></i> Only JPG, PNG, or GIF files are allowed';
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
                const icon = button.querySelector('i');
                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>

</html>