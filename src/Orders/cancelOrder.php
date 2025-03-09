<?php

include_once('businessLogic.php');
$ordersObj = new Orders();


if (!isset($_GET['id'])) {
    die("User ID is missing.");
}
$dateFrom = isset($_GET['dateFrom']) ? $_GET['dateFrom'] : date("Y-m-d", strtotime("-1 day"));
$dateTo = isset($_GET['dateTo']) ? $_GET['dateTo'] : date("Y-m-d");

$id= $_GET['id'];

$ordersObj->cancelOrder($id);
header('Location: userOrders.php?dateFrom='.$dateFrom.'&dateTo='.$dateTo);


?>