<?php
require_once __DIR__ . '/../entities/order.php';
require_once __DIR__ . '/../includes/database.php';

class OrderModel{
    private $db;

    public function __construct($conn){
        $this->db=new Database($conn);
    }

    public function getAllOrders($id){
        $orders=$this->conn->prepare("select * from orders where user_id=".$id);
        return $orders;
    }
    public function getLastFiveOrders($id){
        $orders=$this->conn->prepare("select * from orders where user_id=".$id." limit 5;");
        return $orders;
    }

    public function insertNewOrder($order){
        try{
            $this->db->insert("orders", array_values($orders, ", "));
            return True;
        }catch(PDOException $e){
            return False;
        }
    }

}

?>