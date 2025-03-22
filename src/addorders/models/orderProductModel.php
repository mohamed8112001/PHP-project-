<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../entities/product.php';

class OrderProductModel{
    private $db;

    public function __construct($conn){
        $this->db=new Database($conn);
    }

    public function getAllOrderProducts(){
        $records=$this->db->select("select * from order_product");
        $products=[];
        foreach($records as $record){
            $products[] = new OrderProduct(
                $record['product_id'],
                $record['order_id'],
                $record['quantity'],
            );
        }
        return $products;
    }
}

?>