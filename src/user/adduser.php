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

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="stylee.css">
    <style>

     
    </style>
</head>

<body class="admin-page">
    <?php include_once('../template/nav.php'); ?>

    <div class="page-container">
        <form action="validation.php" method="post" enctype="multipart/form-data" id="registrationForm"
            class="admin-form">
            <div class="form-header">Add New User</div>

            <?php
            if (!empty($success_message)) {
                echo "<div class='success-message'>$success_message</div>";
                echo "<script>setTimeout(() => { window.location.href = 'index.php'; }, 2000);</script>";
            }


            ?>

            <div class="form-group">
                <label for="name">Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" placeholder="Enter your name">
                <?php
                if (isset($errors['name'])) {
                    echo "<span class='error-message'> ⚠️ " . $errors['name'] . "</span>";
                }

                ?>
            </div>

            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" name="email" id="email" placeholder="Enter your email"
                    value="<?php echo htmlspecialchars($email ?? ''); ?>" required aria-describedby="email-error">
                <?php
                if (isset($errors['email'])) {
                    echo "<span class='error-message'> ⚠️ " . $errors['email'] . "</span>";
                }
                ?>

                </span>
            </div>

            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Enter your password" required
                        aria-describedby="password-error">
                    <button type="button" class="toggle-password" aria-label="Toggle password visibility"><i
                            class="fas fa-eye"></i></button>
                </div>
                <!-- <span class="error" id="password-error"></span> -->
                <?php
                if (isset($errors['password'])) {
                    echo "<span class='error-message'> ⚠️ " . $errors['password'] . "</span>";
                }

                ?>
            </div>

            <div class="form-group">
                <label for="Cpassword">Confirm Password <span class="required">*</span></label>
                <div class="password-wrapper">
                    <input type="password" name="Cpassword" id="Cpassword" placeholder="Confirm your password" required
                        aria-describedby="cpassword-error">
                    <button type="button" class="toggle-password" aria-label="Toggle password visibility"><i
                            class="fas fa-eye"></i></button>
                </div>
                <!-- <span class="error" id="cpassword-error"></span> -->
                <?php
                if (isset($errors['cpassword'])) {
                    echo "<span class='error-message'> ⚠️ " . $errors['cpassword'] . "</span>";
                }

                ?>
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
                <!-- <span class="error" id="room-error"></span> -->
                <?php
                if (isset($errors['room_id'])) {
                    echo "<span class='error-message'> ⚠️ " . $errors['room_id'] . "</span>";
                }

                ?>
            </div>

            <div class="form-group">
                <label for="Profile_Picture">Profile Picture</label>
                <input type="file" name="Profile_Picture" id="Profile_Picture" accept="image/*"
                    aria-describedby="file-error">
            </div>

            <div class="button-group">
                <input type="submit" name="register" value="Add User">
                <a href="Home.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </div>

    <?php include_once('../template/footer.php'); ?>

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
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const cpassword = document.getElementById('Cpassword').value;
            const room = document.getElementById('room-no').value;
            const file = document.getElementById('Profile_Picture').files[0];

            document.querySelectorAll('.error').forEach(error => error.textContent = '');

            // if (name.length < 3) {
            //     document.getElementById('name-error').innerHTML = 'Name must be at least 3 characters.';
            //     // name.focus();
            //     isValid = false;
            // } 

            if (!email.includes('@') || !email.includes('.')) {
                document.getElementById('email-error').innerHTML = 'Invalid email format.';
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
                const icon = button.querySelector('i');
                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>

</html>