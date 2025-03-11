<?php
session_start();
include 'config.php';
include 'business_logic.php';

$database = new Database($pdo);
$db       = new BusinessLogic($database);

if (!isset($_GET['id'])) {
    die("طلب غير صالح");
}
$id = $_GET['id'];
$deleted = $db->delete_product($id);
if ($deleted) {
    header("Location: index.php");
    exit();
} else {
    echo "حدث خطأ أثناء حذف المنتج!";
}
?>
