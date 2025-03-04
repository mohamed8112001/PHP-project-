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
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --background-color: #ecf0f1;
            --card-background: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--background-color);
            line-height: 1.6;
            padding: 20px;
        }

        .table-container {
            max-width: 1300px;
            margin: 0 auto;
            background: var(--card-background);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 0.5s ease-in;
        }

        .table-header {
            background: var(--primary-color);
            padding: 15px 20px;
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: var(--primary-color);
            color: white;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        tr {
            transition: all 0.3s ease;
        }

        tr:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }

        img {
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary-color);
            transition: transform 0.3s ease;
        }

        img:hover {
            transform: scale(1.1);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        a {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 25px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
        }

        a.update {
            background: var(--secondary-color);
        }

        a.delete {
            background: var(--danger-color);
        }

        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            color: var(--danger-color);
            text-align: center;
            padding: 20px;
            font-weight: 500;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .table-container {
                margin: 0 10px;
            }

            th, td {
                padding: 10px;
                font-size: 0.9rem;
            }

            img {
                width: 60px;
                height: 60px;
            }

            a {
                padding: 6px 12px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
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
                            <td><img src='" . htmlspecialchars($imagePath) . "' width='80' height='80' alt='Profile'></td>
                            <td class='action-buttons'>
                                <a href='updateUser.php?id=" . htmlspecialchars($user['id'] ?? '') . "' class='update'>Update</a>
                                <a href='deleteUser.php?id=" . htmlspecialchars($user['id'] ?? '') . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>