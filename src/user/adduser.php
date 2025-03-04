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
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --background-color: #f5f6fa;
            --card-background: #ffffff;
            --text-color: #333333;
            --error-color: #e74c3c;
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
        }

        form {
            background: var(--card-background);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-out;
        }

        .form-header {
            text-align: center;
            margin-bottom: 25px;
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 600;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--primary-color);
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
        }

        input[type="file"] {
            padding: 8px;
            background: none;
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
        }

        input[type="submit"]:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        select {
            appearance: none;
            background: #f8f9fa url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="%23333" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 12px center;
        }

        .form-group {
            position: relative;
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
    </style>
</head>
<body>
    <form action="validation.php" method="post" enctype="multipart/form-data">
        <div class="form-header">User Registration</div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="Cpassword">Confirm Password</label>
            <input type="password" name="Cpassword" id="Cpassword" required>
        </div>

        <div class="form-group">
            <label for="room-no">Room No.</label>
            <select name="room-no" id="room-no" required>
                <?php
                $rooms = $user->getAllRooms();
                if (!empty($rooms) && is_array($rooms)) {
                    foreach ($rooms as $room) {
                        echo "<option value='" . htmlspecialchars($room['id']) . "'>" . htmlspecialchars($room['number']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No rooms available</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="ext">Ext.</label>
            <input type="text" name="ext" id="ext">
        </div>

        <div class="form-group">
            <label for="Profile_Picture">Profile Picture</label>
            <input type="file" name="Profile_Picture" id="Profile_Picture" accept="image/*">
        </div>

        <input type="submit" name="send" value="Submit">
    </form>
</body>
</html>