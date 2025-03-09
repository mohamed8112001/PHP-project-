<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            background: white;
            padding: 20px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            text-align: left;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 15px;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
            font-size: 18px;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update User Information</h2>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include_once('blogic.php');

    $blogic = new User();
    $id = $_GET['id'] ?? null;

    if ($id) {
        $user = $blogic->getUserById($id);
        if ($user) {
            echo "<p>Updating user: <strong>" . htmlspecialchars($user['name']) . "</strong></p>";
        } else {
            echo "<p class='error'>User not found.</p>";
        }
    } else {
        echo "<p class='error'>No user ID provided.</p>";
    }
    ?>
<form  method=post>
    <input type="hidden"name=id value="<?php echo htmlspecialchars($user['id'])  ?>">

    <label for="name">Name</label><br>
    <input type="text"name=name value="<?php echo htmlspecialchars($user['name'])  ?>"><br>
    
    <label for="name">Email</label><br>
    <input type="text"name=email value="<?php echo htmlspecialchars($user['email'])  ?>"><br>
    
    <label for="name">Room No.</label><br>
    <input type="text"name=room_id value="<?php echo htmlspecialchars($user['room_id'])  ?>"><br>
    
    <label for="name">Role</label><br>
    <input type="text"name=role value="<?php echo htmlspecialchars($user['role'])  ?>"><br>

    <!-- <label for="">Ext.</label><br>
    <input type="text" name="ext" value="<?php echo htmlspecialchars($user['ext']) ?>"><br>

    <label for="">Profile Picture</label>
    <input type="file" name="Profile_Picture" value="<?php echo htmlspecialchars($user['Profile_Picture']) ?>"> -->

    <input type="submit">
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);

    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $room_id = $_POST['room_id'] ?? null; 
    $role = $_POST['role'] ?? null;

    if ($id && $name && $email && $room_id && $role) {
        $updateData = [
            'name' => $name,
            'email' => $email,
            'room_id' => $room_id,
            'role' => $role
        ];
        $blogic->updateUser($updateData,$id);
        header("Location: All_Users.php");
        exit;
    } else {
        echo "All items must be filled out.";
    }
}

?>
</div>

</body>
</html>