<?php
// session_start(); 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!file_exists('blogic.php')) {
    die('Error: blogic.php file not found.');
}
include_once('blogic.php');
include_once('config.php');

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully!";
// } catch (PDOException $e) {
//     die("Failed in connection: " . $e->getMessage());
// }

$user = new User();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<form action="validation.php" method="post" enctype="multipart/form-data">
        <label for="">Name</label>
        <input type="text" name="name">

        <label for="">Email</label>
        <input type="email" name="email">

        <label for="">Password</label>
        <input type="password" name="password">

        <label for="">Confirm Password</label>
        <input type="password" name="Cpassword">

        <label for="">Room No.</label>
        <select name="room-no">
            <?php
                $rooms = $user->getAllRooms();
                if (!empty($rooms) && is_array($rooms)) {
                    foreach ($rooms as $room) {
                        echo "<option value='".$room['id']."'>". $room['number']."</option>";
                    }
                } else {
                    echo "<option value=''>No rooms available</option>";
                }
            ?>
        </select>

        <label for="">Ext.</label>
        <input type="text" name="ext">

        <label for="">Profile Picture</label>
        <input type="file" name="Profile_Picture">

        <input type="submit" name="send" value="Submit">
    </form>

</body>
</html>
