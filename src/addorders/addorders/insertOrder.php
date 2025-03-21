<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'entities/order.php';
    require_once 'controllers/orderController.php';
    require_once 'includes/connector.php';

    try {
        $rc = new OrderController();
        $date = $_POST['date'] ?? date('Y-m-d H:i:s');
        $status = $_POST['status'] ?? 'Processing';
        $notes = $_POST['notes'] ?? '';
        $user_id = $_POST['user_id'] ?? $_SESSION['user_id'] && !empty($_SESSION['user_id'])  ?? null;
        $room_id = $_POST['room_id'];
        $total_price = $_POST['total_price'];    
        
        $order = [
            "date" => $date, 
            "status" => $status,
            "notes" => $notes, 
            "user_id" => $user_id, 
            "room_id" => $room_id,
        ];
        
        print_r($order);
        $res = $rc->insetOrder($order);
        
        if ($res) {
            $order_id = $rc->getLastInsertId();
            print_r($_POST['orderItemsData']);

            if (!empty($_POST['orderItemsData'])) {
                $orderItems = json_decode($_POST['orderItemsData'], true);
                
                if (is_array($orderItems) && count($orderItems) > 0) {
                    global $conn;
                    $itemStmt = $conn->prepare("insert into order_product (order_id, product_id, quantity, price) 
                                             values (:order_id, :product_id, :quantity, :price)");
                    
                    foreach ($orderItems as $item) {
                        $itemStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                        $itemStmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
                        $itemStmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                        $itemStmt->bindParam(':price', $item['price'], PDO::PARAM_INT);
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
            header("Location: index.php?id=" . $order_id);
            exit();
        } else {
            throw new Exception("Failed to insert order");
        }
    } catch (Exception $e) {
        print($e->getMessage());
        error_log("Order insertion error: " . $e->getMessage());
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        // header("Location: index.php");
        // exit();
    }
} else {
        header("Location: index.php");
        exit();
}
?>