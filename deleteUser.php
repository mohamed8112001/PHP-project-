<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('blogic.php');

$blogic = new User();
$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $blogic->getConnection()->prepare("DELETE FROM user WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: All_Users.php"); 
    exit;
} else {
    echo "No user ID provided.";
}
?>