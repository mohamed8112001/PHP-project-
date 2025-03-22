<?php
session_start();
// if(empty($_SESSION['username'])|| $_SESSION['role']=='admin' )
// 	header("Location: $location ");

$userId=$_SESSION['user_id'] ;
include_once('../template/user_nav.php');


?>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="assets/style.css">

</head>

<body>
<div class="orders-container">
    <h1 class="page-title animate__animated animate__fadeIn">My Orders</h1>

    <?php 
    if (isset($_SESSION['error']))
    {
        echo '<div class="alert animate__animated animate__fadeIn">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>

    <div class="filter-container animate__animated animate__fadeIn">
        <form action="dateValidation.php" method="GET" class="w-100 d-flex flex-wrap align-items-center gap-3">
            <input type="date" id="dateFrom" name="dateFrom" placeholder="Date from" class="date-input " required>
            <input type="date" id="dateTo" name="dateTo" placeholder="Date to" class="date-input" required>
            <button type="submit" id="submit" class="filter-btn">
                <i class="fas fa-filter me-2"></i>Filter Orders
            </button>
        </form>
    </div>

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
    $orders= $ordersObj->userOrders($userId,$dateFrom,$dateTo);
    $totalMoney=0;
    ?>

    <table class="orders-table animate__animated animate__fadeIn"> 
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($orders as $order)
        {
            echo "<tr class='order-row'>";
            echo "<td>{$order['order_id']}</td>";            
            echo "<td>{$order['order_date']} 
                    <span class='toggle-btn' onclick='toggleDetails({$order['order_id']})'> + </span>
                  </td>";
            
            $statusClass = "";
            switch($order['order_status']) {
                case "Processing":
                    $statusClass = "status-processing";
                    break;
                case "Done":
                    $statusClass = "status-completed";
                    break;
                case "Out for delivery":
                    $statusClass = "status-delivery";
                    break;
                default:
                    $statusClass = "";
            }
            echo "<td><span class='status-badge {$statusClass}'>{$order['order_status']}</span></td>";
            
            echo "<td>$" . number_format($order['order_amount'], 2) . "</td>";
                        
            if($order['order_status'] == "Processing")
            {
                $id = $order['order_id'];
                echo "<td>
                        <a href='#' class='cancel-btn' onclick='confirmCancel($id, \"$dateFrom\", \"$dateTo\")'>
                            <i class='fas fa-times me-1'></i>Cancel
                        </a>
                      </td>";
            } else {
                echo "<td></td>";
            }
            
            echo "</tr>";

            echo "<tr id='details-{$order['order_id']}' class='hidden order-details-row'>";
            echo "<td colspan='5' class='order-details'>";
            
            $products = $ordersObj->userOrderProducts($order['order_id']);
            
            foreach($products as $product)
            {
                echo "<div class='product-item'>";
                echo "<div class='product-name'>{$product['product_name']}</div>";
                echo "<div class='product-price'>EGP " . number_format($product['product_price'], 2) . "</div>";
                echo "<div class='product-quantity'>{$product['product_order_quantity']}</div>";
                echo "</div>";
            }
            
            echo "</td></tr>";
            
            $totalMoney += $order['order_amount'];
        }
        ?>
        </tbody>
    </table>
    
    
    <?php if(count($orders) > 0): ?>
    <div class="total-container animate__animated animate__fadeIn">
        Total Amount: $<?php echo number_format($totalMoney, 2); ?>
    </div>
    <?php else: ?>
    <div class="alert animate__animated animate__fadeIn">
        No orders found for the selected date range.
    </div>
    <?php endif; ?>

</div>
?>	
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="assets/javaS.js"></script>
<!-- </body> -->



<?php
include_once('../template/footer.php')
?>

