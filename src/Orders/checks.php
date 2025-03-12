<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 

#include_once('template/header.php');

include_once('businessLogic.php');
$usersChecks = new Orders();
include_once('nav.php');

?>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="assets/style.css">

</head>

<body>
<div class="orders-container">
    <h1 class="page-title animate__animated animate__fadeIn">Checks</h1>

   
<?php 
if (isset($_SESSION['error']))
{
	echo $_SESSION['error'];
	unset($_SESSION['error']);
}
?>

<div class="filter-container animate__animated animate__fadeIn">
        <form action="dateValidation.php" method="GET" class="w-100 d-flex flex-wrap align-items-center gap-3">
            <input type="hidden" name="path" value="2">
            <input type="date" id="dateFrom" name="dateFrom" placeholder="Date from" class="date-input " required>

            <input type="date" id="dateTo" name="dateTo" placeholder="Date to" class="date-input" required>
            <select name="user" id="user"   >
               <option value="">User</option> 
            	<?php
		            $users=$usersChecks->getAllUsers();
		            foreach ($users as $user) {
			            echo "<option value='".$user['id']."'>".$user['name']."</option>";
        	        }
	            ?>  
        	</select>
            <button type="submit" id="submit" class="filter-btn">
                <i class="fas fa-filter me-2"></i>Filter Orders
            </button>
            
            
        </form>
    </div>



<table class="orders-table animate__animated animate__fadeIn"> 
	<tr>
		<th>Name</th>
		<th>Total amount</th>
	</tr>

<?php

if (empty($_GET['dateFrom']) || empty($_GET['dateTo'])) {
    $dateFrom=date("Y-m-d", strtotime("-1 day"));
	$dateTo=date("Y-m-d");
}else{
	$dateFrom=$_GET['dateFrom'];
	$dateTo=$_GET['dateTo'];
}
$userID = isset($_GET['user']) ? $_GET['user'] : null;

if($userID)
{
    $checks= $usersChecks->userCheck($userID,$dateFrom,$dateTo);
}else{
    $checks= $usersChecks->userChecks($dateFrom,$dateTo);
}
 

foreach ($checks as $check) {
    echo "<tr class='order-row'>";
    echo "<td><span class='toggle-btn' onclick='toggleDetails({$check['user_id']})'> + </span>{$check['username']}</td>";
    echo "<td>{$check['total_spent']}</td>";
    echo "</tr>";

    echo "<tr id='details-{$check['user_id']}' class='hidden order-details-row'>";
    echo "<td colspan='2' class='order-details'>";
    echo "<table id='orders-{$check['user_id']}' class='orders-subtable'>";
    echo "<tr>";
    echo "<th>Order Date</th>";
    echo "<th>Amount</th>";
    echo "</tr>";

    $orders = $usersChecks->userOrdersChecks($check['user_id'], $dateFrom, $dateTo);
    foreach ($orders as $order) {
        echo "<tr class='order-row'>";
        echo "<td><span class='toggle-btn' onclick='toggleDetails({$order['order_id']})'> + </span>{$order['order_date']}</td>";
        echo "<td>{$order['order_amount']}</td>";
        echo "</tr>";
        
        echo "<tr id='details-{$order['order_id']}' class='hidden order-details-row'>";
        echo "<td colspan='2' class='order-details'>";
        echo "<div class='products-container'>";

        $products = $usersChecks->userOrderProducts($order['order_id']);
        foreach($products as $product) {
            echo "<div class='product-item'>";
            echo "<div class='product-name'>{$product['product_name']}</div>";
            echo "<div class='product-price'>EGP " . number_format($product['product_price'], 2) . "</div>";
            echo "<div class='product-quantity'>{$product['product_order_quantity']}</div>";
            echo "</div>";
        }

        echo "</div></td></tr>";
    }

    echo "</table></td></tr>";
}
#include_once('template/footer.php');
?>



</body>
	
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="assets/javaS.js"></script>



