<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 

#include_once('template/header.php');

?>

<h1>Orders</h1> </br></br></br>

<table> 
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
	echo "<tr>";
    echo"<td>{$order['order_date']}</td>";
    echo"<td>{$order['username']}</td>";
    echo"<td>{$order['room_number']}</td>";
    echo"<td>{$order['eoom_ext']}</td>";
    echo"<td><a href='updateStatus.php?id={$order['order_id']}' id='deliver'>Deliver</a></td>";
	echo "</tr>";

	echo "<tr>
			<td colspan='5' >";
	$products=$ordersObj->userOrderProducts($order['order_id']);
	foreach($products as $product)
	{
		echo "<span>{$product['product_name']} - {$product['product_price']}</span>";
		echo "&emsp; &emsp;";
	}
	echo" </br>";
	foreach($products as $product)
	{
		echo "<span>{$product['product_order_quantity']}</span>";
		echo "&emsp; &emsp;&emsp; &emsp;&emsp; &emsp;&emsp;";
	}
    $totalMoney=$ordersObj->orderTotalPrice($order['order_id']);
    echo "Total= EGP ".$totalMoney[0]['total_price'];
	echo "</td> </tr>";


}
echo "</table>";
#include_once('template/footer.php');
?>



