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
    <style>
        :root {
            --primary: #6b4e31;
            --secondary: #daa520;
            --light: #f5e9d6;
            --dark: #3c2f2f;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--light) 0%, #e6d9c6 100%);
        }

        .page-container {
            min-height: calc(100vh - 100px);
            padding: 20px;
            position: relative;
            overflow-x: auto;
        }

        .table-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .table-header {
            font-size: clamp(24px, 5vw, 32px);
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 20px;
            text-align: center;
            position: relative;
        }

        .table-header::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--secondary);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            min-width: 600px;
        }

        th {
            background: var(--primary);
            color: var(--light);
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: clamp(12px, 2vw, 14px);
        }

        td {
            padding: 12px;
            background: white;
            transition: all 0.3s ease;
            font-size: clamp(12px, 2vw, 16px);
        }

        tr:hover td {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .action-buttons a {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 20px;
            transition: all 0.3s ease;
            font-size: clamp(12px, 1.5vw, 14px);
        }

        .update {
            background: var(--secondary);
            color: var(--dark);
        }

        .delete {
            background: #e74c3c;
            color: white;
        }

        .add-user-container {
            text-align: center;
            margin-top: 20px;
        }

        .add-user {
            background: var(--primary);
            color: var(--light);
            padding: 10px 25px;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
            font-size: clamp(14px, 2vw, 16px);
        }

        .profile-img {
            border-radius: 50%;
            object-fit: cover;
            width: clamp(40px, 10vw, 60px);
            height: clamp(40px, 10vw, 60px);
            transition: transform 0.3s ease;
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            padding: 10px;
            background: rgba(231, 76, 60, 0.1);
            border-radius: 8px;
            font-size: clamp(12px, 2vw, 14px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-container {
                padding: 15px;
            }

            .table-container {
                padding: 15px;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .action-buttons {
                flex-direction: column;
                align-items: flex-start;
            }

            .action-buttons a {
                width: 100%;
                text-align: center;
            }

            .add-user {
                padding: 8px 20px;
            }
        }

        @media (max-width: 480px) {
            .page-container {
                padding: 10px;
            }

            .table-container {
                padding: 10px;
                border-radius: 10px;
            }

            .table-header {
                margin-bottom: 15px;
            }

            .table-header::after {
                width: 40px;
                bottom: -5px;
            }

            th, td {
                padding: 8px;
            }

            .action-buttons a {
                padding: 5px 10px;
            }

            .add-user {
                padding: 8px 15px;
            }
        }
    </style>
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