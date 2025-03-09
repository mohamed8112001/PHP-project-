<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!file_exists('blogic.php')) {
    die('Error: blogic.php file not found.');
}
include_once('blogic.php');
include_once('config.php');

$user = new User();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --background-color: #f5f6fa;
            --card-background: #ffffff;
            --text-color: #333333;
            --error-color: #e74c3c;
            --success-color: #2ecc71;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', 'Arial', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, var(--background-color) 0%, #e9ecef 100%);
        }

        form {
            background: var(--card-background);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-out;
            position: relative;
            overflow: hidden;
        }

        form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
        }

        .form-header {
            text-align: center;
            margin-bottom: 25px;
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        .form-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background: var(--secondary-color);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .form-group:hover label {
            color: var(--secondary-color);
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
            background: #ffffff;
        }

        input[type="file"] {
            padding: 8px;
            background: none;
            border: 2px dashed #e9ecef;
            cursor: pointer;
        }

        input[type="file"]:hover {
            border-color: var(--secondary-color);
        }

        input[type="submit"] {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px;
            cursor: pointer;
            font-weight: 500;
            border-radius: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input[type="submit"]:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        input[type="submit"]:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        select {
            appearance: none;
            background: #f8f9fa url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="%23333" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 12px center;
            padding-right: 30px;
        }

        .form-group {
            position: relative;
        }

        .error {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: -15px;
            margin-bottom: 15px;
            display: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            form {
                padding: 20px;
                margin: 0 10px;
            }

            .form-header {
                font-size: 1.3rem;
            }

            input, select {
                padding: 10px;
                font-size: 0.9rem;
            }
        }

        /* Loading animation for submit button */
        input[type="submit"].loading {
            position: relative;
            pointer-events: none;
            color: transparent;
        }

        input[type="submit"].loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 3px solid #fff;
            border-top: 3px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
    </style>
</head>
<body>
    <form  action="saveData.php" method="post" enctype="multipart/form-data" id="registrationForm">
        <div class="form-header">User Registration</div>

        <div class="form-group">
            <label for="">Room Name</label>
            <input type="text" name="room-no" id="name" required>
            <div class="error" id="nameError">Please enter a valid name</div>
        </div>
        <div class="form-group">
            <label for="">Ext.</label>
            <input type="text" name="ext" id="name" required>
            <div class="error" id="nameError">Please enter a valid name</div>
        </div>
        <input type="submit" name="send" value="Submit">
    </form>

    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('input[type="submit"]');
            submitButton.classList.add('loading');
            
            // Basic client-side validation
            let isValid = true;
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const cpassword = document.getElementById('Cpassword').value;

            if (name.length < 2) {
                document.getElementById('nameError').style.display = 'block';
                isValid = false;
            }

            if (!email.includes('@') || !email.includes('.')) {
                document.getElementById('emailError').style.display = 'block';
                isValid = false;
            }

            if (password.length < 8) {
                document.getElementById('passwordError').style.display = 'block';
                isValid = false;
            }

            // if (password !== cpassword) {
            //     document.getElementById('cpasswordError').style.display = 'block';
            //     isValid = false;
            // }

            if (!isValid) {
                e.preventDefault();
                submitButton.classList.remove('loading');
            }
        });
    </script>
</body>
</html>
