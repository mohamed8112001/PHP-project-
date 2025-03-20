<?php
include_once("mysqlconnection.php"); 
include_once("logic.php"); 

$queryDB = new Query_database($pdo);
$rooms = $queryDB->getAllRooms();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Register.css">

    <title>PHP CoffeeCenter Ordering System</title>

</head>

<body>
    <header>
        <h1>Welcome to CoffeeCenter</h1>
        <nav class="navbar">
            <ul>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container_form">
            <form method="POST" action="Registerback.php" enctype="multipart/form-data">
                <label for="Username">Username</label>
                <input type="text" name="Username" id="Username" required>

                <label for="Email">Email</label>
                <input type="email" name="Email" id="Email" required>

                <label for="Password">Password</label>
                <input type="Password" name="Password" id="Password" required>

                <label for="First_name">Name</label>
                <input type="text" name="First_name" id="First_name" required>


                <label for="profile_image">Profile image</label>
                <input id="image" type="file" name="profile_image" id="profile_image" required>

                <label for="room_id">Room ID</label>
                <select name="room_id" required>
                    <option value="">-- Select a Room --</option>
                    <?php foreach ($rooms as $room) : ?>
                    <option value="<?= htmlspecialchars($room['id']) ?>">
                        <?= htmlspecialchars($room['id']) ?> -
                        <?= htmlspecialchars($room['number']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>


                <input type="hidden" name="Role" value="user">
                <button type="submit">Register</button>

            </form>
            <a href="Login.html" id="link_log">You Already Have An Account</a>

        </div>
    </main>
    <footer>
        <p>All copy right is abroved &COPY;</p>
    </footer>
    <script src="Register.js"></script>
</body>

</html>