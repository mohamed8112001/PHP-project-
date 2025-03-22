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

