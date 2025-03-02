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
    <title>Users Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .table-container {
            width: 95%;
            max-width: 1200px;
            overflow-x: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        thead {
            background-color: #333;
            color: white;
        }
        img {
            border-radius: 10px;
            object-fit: cover;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            margin: 0 5px;
            border-radius: 5px;
            color: white;
        }
        a.update {
            background-color: #007bff;
        }
        a.delete {
            background-color: #dc3545;
        }
        a:hover {
            opacity: 0.8;
        }
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }
            th, td {
                padding: 8px;
            }
            img {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>
<body>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Room NO.</th>
                <th>Role</th>
                <th>Profile Picture</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $allUsers = $blogic->getAllUsers();
            if ($allUsers === false) {
                echo "<tr><td colspan='6' style='color: red;'>Error fetching users. Please try again later.</td></tr>";
            } else {
                foreach ($allUsers as $user) {
                    $imagePath = $user['image_path'] ?? 'uploads/default.jpg'; 
                    
                    echo "
                    <tr>
                        <td>" . htmlspecialchars($user['name'] ?? '') . "</td>
                        <td>" . htmlspecialchars($user['email'] ?? '') . "</td>
                        <td>" . htmlspecialchars($user['room_id'] ?? '') . "</td>
                        <td>" . htmlspecialchars($user['role'] ?? '') . "</td>
                        <td><img src='" . htmlspecialchars($imagePath) . "' width='80' height='80'></td>
                        <td>
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