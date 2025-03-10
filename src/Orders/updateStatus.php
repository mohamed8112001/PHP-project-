<?php 
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 
include_once('businessLogic.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
if($id){
    $ordersObj = new Orders();
    $ordersObj->updateOrderStatus($id);
}else {
    die("Error: Invalid order ID.");
}

header("Location: adminOrders.php ");

?>