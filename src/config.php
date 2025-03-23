<?php
$host="localhost";
$username="mohamed";
$password="Mohamed@8112001";
$database="mydatabase";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>


<?php
// $host = 'sql123.infinityfree.com'; 
// $db   = 'epiz_12345678_my_database';
// $user = 'epiz_12345678'; 
// $pass = 'h60CtuYf5iu79Y';
// $charset = 'utf8mb4';

// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// try {
//     $pdo = new PDO($dsn, $user, $pass, [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
//         PDO::ATTR_EMULATE_PREPARES => false, 
//     ]);
//     echo "Connected successfully"; 
// } catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage()); 
// }
