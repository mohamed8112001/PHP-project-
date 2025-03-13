<?php
require_once __DIR__ . '/../models/orderModel.php';
require_once __DIR__ . '/../includes/connector.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        global $conn;
        $this->orderModel = new OrderModel($conn);
    }

    public function insetOrder($order) {        
        return $this->orderModel->insertNewOrder($order);
    }

    public function isLimitedOrpopular($product) {
        return $this->orderModel->isLimitedOrpopular($product->id);
    }

    public function getLastInsertId() {
        global $conn;
        return $conn->lastInsertId();
    }

    public function getOrderDetails($orderId) {
        try {
            global $conn;
            
            $query = "SELECT o.*, r.number as room_number, u.name as user_name
                     FROM orders o
                     LEFT JOIN rooms r ON o.room_id = r.id
                     LEFT JOIN users u ON o.user_id = u.id
                     WHERE o.id = :order_id";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting order details: " . $e->getMessage());
            return false;
        }
    }

    public function getOrderItems($orderId) {
        return $this->orderModel->getOrderItems($orderId);
    }

    public function viewMyOrders() {
        // session_start();
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: login.php');
        //     exit();
        // }
        
        $userId = $_SESSION['user_id'];
        $orders = $this->orderModel->getAllOrders($userId);
        
        include(__DIR__ . '/../views/user/my_orders.php');
    }
    
    public function viewLastFiveOrders() {
        // session_start();
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: login.php');
        //     exit();
        // }
        
        $userId = $_SESSION['user_id'];
        $orders = $this->orderModel->getLastFiveOrders($userId);
        return $orders;
    }
    
    public function viewAllOrders() {
        // session_start();
        // if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        //     header('Location: login.php');
        //     exit();
        // }
        
        $orders = $this->orderModel->getAllOrders(null);
        return $orders;
    }
}
?>