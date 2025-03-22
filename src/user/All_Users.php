<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('blogic.php');

try {
    $blogic = new User();
} catch (Exception $e) {
    die("Error initializing User class: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Segoe+UI:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylee.css">
 
   
</head>
<body>
    <?php include_once('../template/nav.php'); ?>

    <div class="page-container">
        <div class="table-container">
            <div class="table-header">Users Dashboard</div>
            
            <table aria-label="Users Dashboard">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">Role</th>
                        <th scope="col">Profile</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTable">
                    <?php
                    try {
                        $allUsers = $blogic->getAllUsers();
                        
                        if (!is_array($allUsers)) {
                            echo "<tr><td colspan='6' class='error-message'>Error fetching users. Please try again later.</td></tr>";
                        } elseif (empty($allUsers)) {
                            echo "<tr><td colspan='6' class='error-message'>No users found.</td></tr>";
                        } else {
                            foreach ($allUsers as $user) {
                                $imagePath = !empty($user['image_path']) ? htmlspecialchars($user['image_path']) : 'uploads/default.jpg';
                                $userName = htmlspecialchars($user['name'] ?? 'Unknown User');
                                
                                echo "
                                <tr class='user-row'>
                                    <td>" . $userName . "</td>
                                    <td>" . htmlspecialchars($user['email'] ?? '') . "</td>
                                    <td>" . htmlspecialchars($user['room_id'] ?? '') . "</td>
                                    <td>" . htmlspecialchars($user['role'] ?? '') . "</td>
                                    <td><img src='" . $imagePath . "' class='profile-img' alt='Profile picture for " . $userName . "' loading='lazy'></td>
                                    <td class='action-buttons'>
                                        <a href='updateUser.php?id=" . htmlspecialchars($user['id'] ?? '') . "' class='update'>Update</a>
                                        <a href='deleteUser.php?id=" . htmlspecialchars($user['id'] ?? '') . "' class='delete' onclick='return confirmDelete(event)'>Delete</a>
                                    </td>
                                </tr>";
                            }
                        }
                    } catch (Exception $e) {
                        echo "<tr><td colspan='6' class='error-message'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="add-user-container">
                <a href="adduser.php" class="add-user">Add User</a>
            </div>
        </div>
    </div>

    <?php include_once('../template/footer.php'); ?>

    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const link = event.target;
            const row = link.closest('.user-row');
            
            if (confirm('Are you sure you want to delete this user?')) {
                row.style.transition = 'all 0.5s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-100px)';
                
                setTimeout(() => {
                    window.location.href = link.href;
                }, 500);
            }
            return false;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('.user-row');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Responsive table adjustments
            function adjustTable() {
                const table = document.querySelector('table');
                if (window.innerWidth <= 768) {
                    table.style.display = 'block';
                    table.style.overflowX = 'auto';
                } else {
                    table.style.display = 'table';
                    table.style.overflowX = 'visible';
                }
            }

            adjustTable();
            window.addEventListener('resize', adjustTable);
        });

        // Button animations
        const buttons = document.querySelectorAll('.action-buttons a, .add-user');
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                if (!e.target.classList.contains('delete')) {
                    button.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        button.style.transform = 'scale(1)';
                    }, 100);
                }
            });
        });

        
    </script>
</body>
</html>