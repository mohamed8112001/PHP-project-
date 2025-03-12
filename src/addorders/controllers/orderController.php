<?php
require_once __DIR__ . '/../models/orderModel.php';
require_once __DIR__ . '/../includes/connector.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        global $conn;
        $this->orderModel = new OrderModel($conn);
    }

    public function insetOrder($room){
        // session_start();
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: login.php');
        //     exit();
        // }
        return $this->orderModel->insertNewOrder($room);
    }

    public function isLimitedOrpopular($product){
        return $this->orderModel->isLimitedOrpopular($product->id);
    }

    public function getLastInsertId()
    {
        global $conn;
        return $conn->lastInsertId();
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
        
    }
    
    // public function placeOrder() {
    //     session_start();
    //     if (!isset($_SESSION['user_id'])) {
    //         header('Location: login.php');
    //         exit();
    //     }
        
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $userId = $_SESSION['user_id'];
    //         $roomId = $_POST['room_id'];
    //         $products = isset($_POST['products']) ? $_POST['products'] : [];
    //         $totalAmount = $_POST['total_amount'];
            
    //         $order = [
    //             'user_id' => $userId,
    //             'room_id' => $roomId,
    //             'total_amount' => $totalAmount,
    //             'order_date' => date('Y-m-d H:i:s'),
    //             'status' => 'pending'
    //         ];
            
    //         $result = $this->orderModel->insertNewOrder($order);
            
    //         if ($result) {
    //             header('Location: index.php?action=orderSuccess');
    //             exit();
    //         } else {
    //             $_SESSION['error'] = "Failed to place order. Please try again.";
    //             header('Location: index.php?action=placeOrder');
    //             exit();
    //         }
    //     }
        
    //     $rooms = $this->roomModel->getAllRooms();
        
    // }
    
    // public function adminPlaceOrder() {
    //     session_start();
    //     if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    //         header('Location: login.php');
    //         exit();
    //     }
        
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $userId = $_POST['user_id'];
    //         $roomId = $_POST['room_id'];
    //         $products = isset($_POST['products']) ? $_POST['products'] : [];
    //         $totalAmount = $_POST['total_amount'];
            
    //         $order = [
    //             'user_id' => $userId,
    //             'room_id' => $roomId,
    //             'total_amount' => $totalAmount,
    //             'order_date' => date('Y-m-d H:i:s'),
    //             'status' => 'pending'
    //         ];
            
    //         $result = $this->orderModel->insertNewOrder($order);
            
    //         if ($result) {
    //             header('Location: admin.php?action=orderSuccess');
    //             exit();
    //         } else {
    //             $_SESSION['error'] = "Failed to place order. Please try again.";
    //             header('Location: admin.php?action=placeOrder');
    //             exit();
    //         }
    //     }
        
    //     $users = $this->userModel->getAllUsers();
        
    //     $rooms = $this->roomModel->getAllRooms();
        
    // }
    
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