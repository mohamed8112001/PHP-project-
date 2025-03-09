<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 

#include_once('template/header.php');

?>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
        .hidden {
            display: none;
        }
        .toggle-btn {
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }
        .order-details {
            border-top: 1px solid #ddd;
            padding: 10px;
            background: #f9f9f9;
        }
    </style>

</head>


<h1>My Orders</h1> </br></br></br>


<?php 
if (isset($_SESSION['error']))
{
	echo $_SESSION['error'];
	unset($_SESSION['error']);
}
?>

<form action="dateValidation.php" method="GET">
	<input type="date" id="dateFrom" name="dateFrom" placeholder="Date from" class="datepicker" required>
	<span>&emsp; &emsp;</span>
	<input type="date" id="dateTo" name="dateTo" placeholder="Date to" class="datepicker" required>
	<span>&emsp;</span>
	<input type="submit" id="submit" value="Filter" >
</form>

<table> 
	<tr>
		<th>Order ID</th>
		<th>Order Date</th>
		<th>Status</th>
		<th>Amount</th>
		<th>Action</th>
	</tr>




<?php
include_once('businessLogic.php');
$ordersObj = new Orders();


if (empty($_GET['dateFrom']) || empty($_GET['dateTo'])) {
    $dateFrom=date("Y-m-d", strtotime("-1 day"));
	$dateTo=date("Y-m-d");
}else{
	$dateFrom=$_GET['dateFrom'];
	$dateTo=$_GET['dateTo'];
}
$userId=5;
$orders= $ordersObj->userOrders($userId,$dateFrom,$dateTo);
$totalMoney=0;

foreach($orders as $order)
{
	echo "<tr>";
	foreach($order as $col => $data)
	{		
		if ($col == "order_date")
		{
			echo"<td>$data <span class='toggle-btn' onclick='toggleDetails({$order['order_id']})'> + </span></td>";
		}		
		echo"<td>$data</td>";						
	}
	if( $order['order_status'] == "Processing")
	{
		$id = $order['order_id'];
		echo"<td>
			<a href='#' id='cancel' onclick='confirmCancel($id, \"$dateFrom\", \"$dateTo\")'>CANCEL</a>
			</td> </tr>";
	}else{
		echo "<td></td> </tr>";
	}


	echo "<tr id='details-{$order['order_id']}' class='hidden' >
			<td colspan='5' class='order-details'>";
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
	echo "</td> </tr>";
	$totalMoney+=$order['order_amount'];

}
echo "</table>";
echo "Total= ".$totalMoney;
#include_once('template/footer.php');
?>



<script>

	function toggleDetails(order_id)
	{
		var orderDetails = document.getElementById("details-"+ order_id);
		var btn = orderDetails.previousElementSibling.querySelector(".toggle-btn");

		if(orderDetails.classList.contains("hidden"))
		{
			orderDetails.classList.remove("hidden");
			btn.textContent="-";
		}else{
			orderDetails.classList.add("hidden");
			btn.textContent="+";
		}
	}


    flatpickr(".datepicker", { dateFormat: "Y-m-d" , allowInput: true, maxDate: "today" });

	function confirmCancel(id,dateFrom,dateTo){
		 if(confirm('Are you sure you want to cancel this order?')){
			window.location.href = `cancelOrder.php?id=${id}&dateFrom=${dateFrom}&dateTo=${dateTo}`;
		 }
	}
</script>




