<?php
class OrderModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertNewOrder($order) {
        try {
            $query = "INSERT INTO orders (date, status, notes, user_id, room_id, total_price) 
                     VALUES (:date, :status, :notes, :user_id, :room_id, :total_price)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':date', $order->date);
            $stmt->bindParam(':status', $order->status);
            $stmt->bindParam(':notes', $order->notes);
            $stmt->bindParam(':user_id', $order->user_id);
            $stmt->bindParam(':room_id', $order->room_id);
            $stmt->bindParam(':total_price', $order->total_price);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error in insertNewOrder: " . $e->getMessage());
            return false;
        }
    }
    
    public function isLimitedOrpopular($productId) {
        try {
            $query = "SELECT COUNT(*) as total_orders 
                     FROM order_items 
                     WHERE product_id = :product_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':product_id', $productId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $totalOrders = $result['total_orders'];

            $recentQuery = "SELECT COUNT(*) as recent_orders 
                           FROM order_items oi
                           JOIN orders o ON oi.order_id = o.id
                           WHERE oi.product_id = :product_id 
                           AND o.date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            
            $recentStmt = $this->conn->prepare($recentQuery);
            $recentStmt->bindParam(':product_id', $productId);
            $recentStmt->execute();
            $recentResult = $recentStmt->fetch(PDO::FETCH_ASSOC);
            
            $recentOrders = $recentResult['recent_orders'];
            
            if ($recentOrders >= 10) {
                return "popular";
            } else if ($totalOrders <= 5) {
                return "limited";
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database error in isLimitedOrpopular: " . $e->getMessage());
            return null;
        }
    }
    
    public function getAllOrders($userId = null) {
        try {
            $query = "SELECT o.*, r.number as room_number, u.name as user_name
                     FROM orders o
                     LEFT JOIN rooms r ON o.room_id = r.id
                     LEFT JOIN users u ON o.user_id = u.id";
            
            if ($userId !== null) {
                $query .= " WHERE o.user_id = :user_id";
            }
            
            $query .= " ORDER BY o.date DESC";
            
            $stmt = $this->conn->prepare($query);
            
            if ($userId !== null) {
                $stmt->bindParam(':user_id', $userId);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getAllOrders: " . $e->getMessage());
            return [];
        }
    }
    
    public function getLastFiveOrders($userId) {
        try {
            $query = "SELECT o.*, r.number as room_number
                     FROM orders o
                     LEFT JOIN rooms r ON o.room_id = r.id
                     WHERE o.user_id = :user_id
                     ORDER BY o.date DESC
                     LIMIT 5";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getLastFiveOrders: " . $e->getMessage());
            return [];
        }
    }
    
    public function getOrderItems($orderId) {
        try {
            $query = "SELECT oi.*, p.name as product_name, p.imagePath
                     FROM order_items oi
                     JOIN products p ON oi.product_id = p.id
                     WHERE oi.order_id = :order_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getOrderItems: " . $e->getMessage());
            return [];
        }
    }
}