<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('blogic.php');
$blogic = new User();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Segoe+UI:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylee.css">

    <style>
      
    </style>
</head>
<body>

<?php include_once('templates/nav.php'); ?>

<div class="page-container">
    <div class="table-container">
        <div class="table-header">Users Dashboard</div>
       
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Room No.</th>
                    <th>Role</th>
                    <th>Profile</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $allUsers = $blogic->getAllUsers();
                if ($allUsers === false) {
                    echo "<tr><td colspan='6' class='error-message'>Error fetching users. Please try again later.</td></tr>";
                } else {
                    foreach ($allUsers as $user) {
                        $imagePath = $user['image_path'] ?? 'uploads/default.jpg';
                        echo "
                        <tr>
                            <td>" . htmlspecialchars($user['name'] ?? '') . "</td>
                            <td>" . htmlspecialchars($user['email'] ?? '') . "</td>
                            <td>" . htmlspecialchars($user['room_id'] ?? '') . "</td>
                            <td>" . htmlspecialchars($user['role'] ?? '') . "</td>
                            <td><img src='" . htmlspecialchars($imagePath) . "' width='60' height='60' alt='Profile'></td>
                            <td class='action-buttons'>
                                <a href='updateUser.php?id=" . htmlspecialchars($user['id'] ?? '') . "' class='update'>Update</a>
                                <a href='deleteUser.php?id=" . htmlspecialchars($user['id'] ?? '') . "' class='delete' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <div class="add-user-container">
            <a href="adduser.php" class="add-user">Add User</a>
        </div>
    </div>
</div>
<?php
include_once('templates/footer.php')
?>
</body>
</html>
