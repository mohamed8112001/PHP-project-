<?php
include_once __DIR__ . '/../entities/order.php';

class OrderModel{
    private $db;

    public function __construct($conn){
        $this->db=new Database();
    }

    public function getAllOrders($id){
        $stmt=$this->conn->prepare("select * from order where user_id=".$id);
        $stmt->execute();

    }

}

?>