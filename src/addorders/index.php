<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Order</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <!-- <link rel="stylesheet" href="/var/www/html/php_pro/src/template/styleTemplate.css"> -->
</head>
<body>

    <?php include '../template/nav.php';?>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-5">
                <div class="order-card">
                    <h4 class="mb-4">Current Order</h4>

                    <form id="orderForm" method="POST" action="insertOrder.php">
                        <div id="orderItems">
                            <input type="hidden" id="orderItemsData" name="orderItemsData" value="">
                        </div>

                        <div class="mt-4">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control notes-input" name="notes" rows="3">1 Tea Extra Sugar</textarea>
                        </div>

                        <?php include __DIR__ . '/views/widgets/selectRoom.php';  ?>

                        <input type="hidden" name="user_id" id="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
                        <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>">
                        <input type="hidden" name="status" value="Processing">

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="total-price">EGP <span id="totalPriceValue">0</span></div>
                            <input type="hidden" name="total_price" id="totalPriceInput" value="0">
                            <button type="submit" class="btn btn-confirm" id="confirmButton">
                                <i class="fas fa-check me-2"></i>Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-7">
                <?php 
                include 'controllers/orderController.php';
                
                if (!empty($_SESSION) && isset($_SESSION['role'])){
                    if ($_SESSION['role'] == 'admin'){
                        include __DIR__ . '/views/admin/addToUser.php';
                    }else{
                        include __DIR__ . '/views/user/last_orders.php';
                    }
                }else{
                    include __DIR__ . '/views/user/last_orders.php';
                }
                ?>
                <?php include __DIR__ . '/views/widgets/list.php'; ?>                
            </div>
        </div>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="index.js"></script>
    
</body>
</html>