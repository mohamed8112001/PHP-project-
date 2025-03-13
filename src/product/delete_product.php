<?php
session_start();
include '../config.php';
include 'business_logic.php';

$database = new Database($pdo);
$db       = new BusinessLogic($database);

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = $_GET['id'];
$deleted = $db->delete_product($id);
if ($deleted) {
    header("Location: index.php");
    exit();
} else {
    echo "An error occurred while deleting the product!";
}
?>
