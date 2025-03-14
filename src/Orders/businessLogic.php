<?php
include_once('database.php');

class Orders 
{
	private $db;
	public function __construct()
	{
		$this->db= new Database();
	}
	
	public function userOrders($userId,$dateFrom,$dateTo){

		$sql = "SELECT o.id AS order_id, o.date AS order_date,o.status AS order_status,SUM(op.quantity * p.price) AS order_amount FROM orders o JOIN user u ON o.user_id = u.id JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id WHERE o.user_id = :userId and DATE(o.date) BETWEEN :dateFrom AND :dateTo GROUP BY o.id;";

		return $this->db->select($sql,[':userId'=>$userId, ':dateFrom'=> date($dateFrom), ':dateTo'=> date($dateTo)]);			
	}



	// public function userOrders($userId,$dateFrom,$dateTo){

	// 	echo "1";
	// 	$tablename= "orders o JOIN user u ON o.user_id = u.id JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id";
	// 	$conditions= ["o.user_id" =>$userId,"DATE(o.date) BETWEEN '{$dateFrom}' AND '{$dateTo}'"=>null];
	// 	$columns=["o.id AS order_id","o.date AS order_date","o.status AS order_status","SUM(op.quantity * p.price) AS order_amount"];
	// 	$groupBy= 'o.id';

	// 	return $this->db->select($tablename, $conditions, true, $columns, $groupBy );
	// }


	public function userOrderProducts($orderId){

		$sql = "SELECT p.name AS product_name,
    				p.price AS product_price,    
    				op.quantity AS product_order_quantity                       
                    FROM order_product op 
					JOIN product p ON op.product_id = p.id
                    WHERE op.order_id = :orderId ";

		return $this->db->select($sql,[':orderId'=>$orderId]);			
	}

	public function cancelOrder($id){
		$condition="id= $id";
		$this->db->delete("orders", $condition);
	}

	public function userChecks($dateFrom,$dateTo){

		$sql = "SELECT u.id AS user_id ,u.name AS username, SUM(p.price * op.quantity) AS total_spent FROM user u JOIN orders o ON u.id = o.user_id JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id WHERE DATE(o.date) BETWEEN :dateFrom AND :dateTo  GROUP BY u.id";
			

		return $this->db->select($sql,[':dateFrom'=> date($dateFrom), ':dateTo'=> date($dateTo)]);			
	}

	public function userOrdersChecks($userId,$dateFrom,$dateTo){

		$sql = "SELECT o.id AS order_id, o.date AS order_date,SUM(op.quantity * p.price) AS order_amount FROM orders o JOIN user u ON o.user_id = u.id JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id WHERE o.user_id = :userId and DATE(o.date) BETWEEN :dateFrom AND :dateTo GROUP BY o.id;";

		return $this->db->select($sql,[':userId'=>$userId, ':dateFrom'=> date($dateFrom), ':dateTo'=> date($dateTo)]);			
	}

	public function userCheck($userId,$dateFrom,$dateTo){

		$sql = "SELECT u.id AS user_id ,u.name AS username, SUM(p.price * op.quantity) AS total_spent FROM user u JOIN orders o ON u.id = o.user_id JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id WHERE u.id = :userId AND DATE(o.date) BETWEEN :dateFrom AND :dateTo GROUP BY u.id, u.name  ";

		return $this->db->select($sql,[':userId'=>$userId, ':dateFrom'=> date($dateFrom), ':dateTo'=> date($dateTo)]);			
	}
	public function getAllUsers(){
		return $this->db->selectAll("user");
	}


	public function adminProcessingOrders(){

		$sql = "SELECT o.id AS order_id, o.date AS order_date, u.id AS user_id ,u.name AS username, r.number AS room_number, r.ext AS eoom_ext                     
                    FROM orders o JOIN user u ON o.user_id = u.id JOIN room r ON u.room_id = r.id
                    WHERE o.status = 'Processing'";

		return $this->db->select($sql,[]);			
	}

	public function orderTotalPrice($orderId){
		$sql="SELECT SUM(p.price * op.quantity) AS total_price
				FROM orders o
				JOIN order_product op ON o.id = op.order_id
				JOIN product p ON op.product_id = p.id
				WHERE o.id = :orderId";

		return $this->db->select($sql,[':orderId'=>$orderId]);			
	}

	public function updateOrderStatus($orderId){

		$values=array("Out for delivery",$orderId);
		$columns=array("status"); 
		$condition="id= ?";
		$this->db->update("orders", $columns, $values, $condition);
	}

}

?>

