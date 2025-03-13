<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'controllers/orderController.php';
    require_once 'includes/connector.php';

    try {
        $rc = new OrderController();
        $date = $_POST['date'] ?? date('Y-m-d H:i:s');
        $status = $_POST['status'] ?? 'Processing';
        $notes = $_POST['notes'] ?? '';
        $user_id = $_POST['user_id'] ?? null;
        $room_id = $_POST['room_id'] ?? 0;
        $total_price = $_POST['total_price'] ?? 0;
        if (empty($room_id)) {
            throw new Exception("Room selection is required");
        }
        
        $order = new Order([
            "date" => $date, 
            "status" => $status,
            "notes" => $notes, 
            "user_id" => $user_id, 
            "room_id" => $room_id,
            "total_price" => $total_price
        ]);

        $res = $rc->insetOrder($order);
        
        if ($res) {
            $order_id = $rc->getLastInsertId();
            if (!empty($_POST['orderItemsData'])) {
                $orderItems = json_decode($_POST['orderItemsData'], true);
                
                if (is_array($orderItems) && count($orderItems) > 0) {
                    global $conn;
                    $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                                             VALUES (:order_id, :product_id, :quantity, :price)");
                    
                    foreach ($orderItems as $item) {
                        $itemStmt->bindParam(':order_id', $order_id);
                        $itemStmt->bindParam(':product_id', $item['product_id']);
                        $itemStmt->bindParam(':quantity', $item['quantity']);
                        $itemStmt->bindParam(':price', $item['price']);
                        $itemStmt->execute();
                    }
                    error_log("Successfully inserted " . count($orderItems) . " order items for order #" . $order_id);
                } else {
                    error_log("Order items data was invalid: " . $_POST['orderItemsData']);
                }
            } else {
                error_log("No order items data provided for order #" . $order_id);
            }
            $_SESSION['success_message'] = "Order has been placed successfully!";
            header("Location: order_confirmation.php?id=" . $order_id);
            exit();
        } else {
            throw new Exception("Failed to insert order");
        }
    } catch (Exception $e) {
        error_log("Order insertion error: " . $e->getMessage());
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>