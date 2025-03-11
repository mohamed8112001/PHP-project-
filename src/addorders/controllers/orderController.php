<?php
require_once __DIR__ . '/../models/orderModel.php';
require_once __DIR__ . '/../models/userModel.php';
require_once __DIR__ . '/../models/roomModel.php';
require_once __DIR__ . '/../includes/connector.php';

class OrderController {
    private $orderModel;
    private $userModel;
    private $roomModel;

    public function __construct() {
        global $conn;
        $this->orderModel = new OrderModel($conn);
        $this->userModel = new UserModel($conn);
        $this->roomModel = new RoomModel($conn);
    }

    public function viewMyOrders() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $orders = $this->orderModel->getAllOrders($userId);
        
        include(__DIR__ . '/../views/user/my_orders.php');
    }
    
    public function viewLastFiveOrders() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $orders = $this->orderModel->getLastFiveOrders($userId);
        
    }
    
    public function placeOrder() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $roomId = $_POST['room_id'];
            $products = isset($_POST['products']) ? $_POST['products'] : [];
            $totalAmount = $_POST['total_amount'];
            
            $order = [
                'user_id' => $userId,
                'room_id' => $roomId,
                'total_amount' => $totalAmount,
                'order_date' => date('Y-m-d H:i:s'),
                'status' => 'pending'
            ];
            
            $result = $this->orderModel->insertNewOrder($order);
            
            if ($result) {
                header('Location: index.php?action=orderSuccess');
                exit();
            } else {
                $_SESSION['error'] = "Failed to place order. Please try again.";
                header('Location: index.php?action=placeOrder');
                exit();
            }
        }
        
        $rooms = $this->roomModel->getAllRooms();
        
        include(__DIR__ . '/../views/user/place_order.php');
    }
    
    public function adminPlaceOrder() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: login.php');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $roomId = $_POST['room_id'];
            $products = isset($_POST['products']) ? $_POST['products'] : [];
            $totalAmount = $_POST['total_amount'];
            
            $order = [
                'user_id' => $userId,
                'room_id' => $roomId,
                'total_amount' => $totalAmount,
                'order_date' => date('Y-m-d H:i:s'),
                'status' => 'pending'
            ];
            
            $result = $this->orderModel->insertNewOrder($order);
            
            if ($result) {
                header('Location: admin.php?action=orderSuccess');
                exit();
            } else {
                $_SESSION['error'] = "Failed to place order. Please try again.";
                header('Location: admin.php?action=placeOrder');
                exit();
            }
        }
        
        $users = $this->userModel->getAllUsers();
        
        $rooms = $this->roomModel->getAllRooms();
        
        include(__DIR__ . '/../views/admin/place_order.php');
    }
    
    public function viewAllOrders() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: login.php');
            exit();
        }
        
        $orders = $this->orderModel->getAllOrders(null);

        include(__DIR__ . '/../views/admin/all_orders.php');
    }
}
?>