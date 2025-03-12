<?php
session_start(); // Start session for potential future use
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('business_logic.php');
include_once('templates/header.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="templates/style.css">
    <style></style>
</head>
<body>


    <div class="page-container">
    <form action="saveData.php" method="post"  id="registrationForm">
            <div class="form-header">Add New Category</div>

            <?php
            // if (!empty($success_message)) {
            //     echo "<div class='success-message'>$success_message</div>";
            //     echo "<script>
            //             setTimeout(() => {
            //                 window.location.href = 'index.php'; // Redirect to dashboard, not self
            //             }, 2000);
            //           </script>";
            // }

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