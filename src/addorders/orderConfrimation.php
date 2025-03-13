<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controllers/orderController.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if we have an order ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "No order ID provided.";
    header("Location: index.php");
    exit();
}

$orderId = $_GET['id'];
$controller = new OrderController();
$order = $controller->getOrderDetails($orderId);
if (!$order) {
    $_SESSION['error_message'] = "Order not found.";
    header("Location: index.php");
    exit();
}

$orderItems = $controller->getOrderItems($orderId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php include __DIR__ . '/views/layout/header.php'; ?>
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="order-card">
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> <?php echo $_SESSION['success_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success_message']); ?>
                    <?php endif; ?>
                    
                    <h3 class="mb-4 text-center">
                        <i class="fas fa-check-circle text-success me-2"></i> Order Confirmed!
                    </h3>
                    
                    <div class="text-center mb-4">
                        <span class="badge bg-success p-2">Order #<?php echo $orderId; ?></span>
                        <span class="badge bg-secondary p-2 ms-2"><?php echo $order['status']; ?></span>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Order Details</h5>
                            <p><strong>Date:</strong> <?php echo date('M d, Y h:i A', strtotime($order['date'])); ?></p>
                            <p><strong>Room:</strong> <?php echo $order['room_number']; ?></p>
                            <?php if (!empty($order['user_name'])): ?>
                                <p><strong>User:</strong> <?php echo $order['user_name']; ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <h5>Notes</h5>
                            <p><?php echo !empty($order['notes']) ? $order['notes'] : 'No notes provided'; ?></p>
                        </div>
                    </div>
                    
                    <h5 class="mb-3">Order Items</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($item['imagePath'])): ?>
                                                <img src="<?php echo $item['imagePath']; ?>" alt="<?php echo $item['product_name']; ?>" 
                                                     class="me-2" style="width: 30px; height: 30px; border-radius: 50%;">
                                            <?php endif; ?>
                                            <?php echo $item['product_name']; ?>
                                        </div>
                                    </td>
                                    <td>EGP <?php echo $item['price']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td class="text-end">EGP <?php echo $item['price'] * $item['quantity']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end">EGP <?php echo $order['total_price']; ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Ordering
                        </a>
                        <a href="#" class="btn btn-primary" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Print Receipt
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.from(".order-card", {
                duration: 0.8,
                y: 50,
                opacity: 0,
                ease: "back.out(1.7)"
            });
            
            gsap.to(".fa-check-circle", {
                rotation: 360,
                duration: 1,
                ease: "elastic.out(1, 0.3)"
            });
            
            gsap.from("tbody tr", {
                duration: 0.5,
                opacity: 0,
                y: 20,
                stagger: 0.1,
                ease: "power1.out",
                delay: 0.5
            });
        });
    </script>
</body>
</html>