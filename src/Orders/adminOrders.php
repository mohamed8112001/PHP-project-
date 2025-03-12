<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 

include_once('nav.php');

?>

<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="orders-container">
    <h1 class="page-title animate__animated animate__fadeIn">Orders</h1>


	<table class="orders-table animate__animated animate__fadeIn"> 
	<tr>
		<th>Order Date</th>
		<th>Name</th>
		<th>Room</th>
        <th>Ext</th>
		<th>Action</th>
	</tr>



<?php
include_once('businessLogic.php');

$ordersObj = new Orders();
$orders= $ordersObj->adminProcessingOrders();
$totalMoney=0;

foreach($orders as $order)
{
	echo "<tr class='order-row'>";
    echo"<td>{$order['order_date']}</td>";
    echo"<td>{$order['username']}</td>";
    echo"<td>{$order['room_number']}</td>";
    echo"<td>{$order['eoom_ext']}</td>";
    echo"<td><a href='updateStatus.php?id={$order['order_id']}' id='deliver class='cancel-btn'>Deliver</a></td>";
	echo "</tr>";

	echo "<tr>
			<td colspan='5' >";
	$products=$ordersObj->userOrderProducts($order['order_id']);
	foreach($products as $product)
            {
                echo "<div class='product-item'>";
                echo "<div class='product-name'>{$product['product_name']}</div>";
                echo "<div class='product-price'>EGP " . number_format($product['product_price'], 2) . "</div>";
                echo "<div class='product-quantity'>{$product['product_order_quantity']}</div>";
                echo "</div>";
            }
    $totalMoney=$ordersObj->orderTotalPrice($order['order_id']);
    echo "<br><div class='total-small animate__animated animate__fadeIn'>
        Total Amount: EGP {$totalMoney[0]['total_price']}
    </div>";
	echo "</td> </tr>";


}
echo "</table>";
#include_once('template/footer.php');
?>
	

</body>
	
<script src="assets/javaS.js"></script>

