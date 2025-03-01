<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('blogic.php');

$blogic = new User();
$id = $_GET['id'] ?? null;

if ($id) {
    $user = $blogic->select('user', ['id' => $id], false);
    if ($user) {
        header("Location: adduser.php");
        echo "Update form for user: " . htmlspecialchars($user['name']);
    } else {
        echo "User not found.";
    }
} else {
    echo "No user ID provided.";
}
?>