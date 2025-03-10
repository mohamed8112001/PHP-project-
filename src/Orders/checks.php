<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 

#include_once('template/header.php');

include_once('businessLogic.php');
$usersChecks = new Orders();

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


<h1>Checks</h1> </br></br></br>


<?php 
if (isset($_SESSION['error']))
{
	echo $_SESSION['error'];
	unset($_SESSION['error']);
}
?>

<form action="dateValidation.php" method="GET">
    <input type="hidden" name="path" value="2">
	<input type="date" id="dateFrom" name="dateFrom" placeholder="Date from" class="datepicker" required>
	<span>&emsp; &emsp;</span>
	<input type="date" id="dateTo" name="dateTo" placeholder="Date to" class="datepicker" required>
	<span>&emsp;</span>
    <input type="submit" id="submit" value="Filter" >
    </br></br>
    <select name="user" id="user"  >
    <option value="">User</option> 
	<?php
		$users=$usersChecks->getAllUsers();
		foreach ($users as $user) {
			echo "<option value='".$user['id']."'>".$user['name']."</option>";
        	}
	?>
	</select>
</form>


<table> 
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
    echo "<tr>";
    echo "<td><span class='toggle-btn' onclick='toggleDetails({$check['user_id']})'> + </span>{$check['username']}</td>";
    echo "<td>{$check['total_spent']}</td>";
    echo "</tr>";

    echo "<tr id='details-{$check['user_id']}' class='hidden'>
            <td colspan='2'>
                <table id='orders-{$check['user_id']}' class='hidden'>
                        <tr>
                            <th>Order Date</th>
                            <th>Amount</th>
                        </tr>";

    $orders = $usersChecks->userOrdersChecks($check['user_id'], $dateFrom, $dateTo);
    foreach ($orders as $order) {
        echo "<tr>";
        echo "<td><span class='toggle-btn' onclick='toggleDetails({$order['order_id']})'> + </span>{$order['order_date']}</td>";
        echo "<td>{$order['order_amount']}</td>";
        echo "</tr>";
        
        echo "<tr id='details-{$order['order_id']}' class='hidden'>
                <td colspan='2' class='order-details'>";

        $products = $usersChecks->userOrderProducts($order['order_id']);
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

        echo "</td></tr>";
    }

    echo "</table></td></tr>";
}
#include_once('template/footer.php');
?>



<script>

function toggleDetails(id) {
    var detailsRow = document.getElementById("details-" + id);
    var btn = document.querySelector("[onclick='toggleDetails(" + id + ")']");

    if (detailsRow) {
        detailsRow.classList.toggle("hidden");
        
        var ordersTable = detailsRow.querySelector("table");
        if (ordersTable) {
            ordersTable.classList.toggle("hidden");

            var header = ordersTable.querySelector("thead");
            if (header) {
                header.classList.toggle("hidden");
            }
        }
        btn.textContent = detailsRow.classList.contains("hidden") ? "+" : "-";
    }
}

    flatpickr(".datepicker", { dateFormat: "Y-m-d" , allowInput: true, maxDate: "today" });

	
</script>



