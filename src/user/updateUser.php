<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('blogic.php');

$blogic = new User();
$id = $_GET['id'] ?? null;

// Handle form submission first
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $blogic->updateUser($updateData, $id);
        header("Location: All_Users.php"); // Redirect before any output
        exit;
    } else {
        $error_message = "All fields must be filled out.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Segoe+UI:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylee.css">
</head>
<body class="background">
    <?php include_once('../template/nav.php'); ?>
    <div class="container">
        <h2>Update User Information</h2>

        <?php
        if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }

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

        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id'] ?? ''); ?>">

            <label for="name">Name <span class="required">*</span></label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>

            <label for="email">Email <span class="required">*</span></label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>

            <label for="room_id">Room No. <span class="required">*</span></label>
            <input type="text" name="room_id" id="room_id" value="<?php echo htmlspecialchars($user['room_id'] ?? ''); ?>" required>

            <label for="role">Role <span class="required">*</span></label>
            <input type="text" name="role" id="role" value="<?php echo htmlspecialchars($user['role'] ?? ''); ?>" required>

            <input type="submit" value="Update User">
        </form>
    </div>
</body>
</html>