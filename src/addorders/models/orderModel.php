<?php
require_once __DIR__ . '/../entities/order.php';
require_once __DIR__ . '/../includes/database.php';

class OrderModel{
    private $db;


    public function __construct($conn){
        $this->db=new Database($conn);
    }


    public function isLimitedOrpopular($id){
        $res = $this->db->select('SELECT op.product_id,IF(p3.product_id IS NOT NULL, "popular", "normal") AS popularity FROM order_product op LEFT JOIN (SELECT product_id FROM order_product GROUP BY product_id ORDER BY COUNT(*) DESC LIMIT 3 ) AS p3 ON op.product_id = p3.product_id GROUP BY op.product_id;' , [":id"=> $id]);
        if(!empty($res) &&  $res[0]['status'] == "popular"){
            return 'popular';
        }else {
            $res2 = $this->db->select('select if(amount >3 , "normal" , "limited")as status from product where id=:id', ["id"=> $id]);
            return !empty($res2) ? $res2[0]['status'] : 'limited';
        }
    }

    public function getAllOrders($id){
        $orders=$this->db->select("select * from orders where user_id=:id" , [":id"=>$id]);
        return $orders;
    }
    public function getLastFiveOrders($id){
        $orders=$this->db->select("select * from orders where user_id=:id limit 5;", [":id"=>$id]);
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