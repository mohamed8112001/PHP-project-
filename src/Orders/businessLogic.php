<?php
include_once('../database.php');

class Orders 
{
	private $db; 

    public function __construct() {
        $this->db = new Database();
    }


	public function userOrders($userId, $dateFrom, $dateTo) {
		$tablename = "orders o JOIN user u ON o.user_id = u.id JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id";
		$columns = ["o.id AS order_id", "o.date AS order_date", "o.status AS order_status", "SUM(op.quantity * p.price) AS order_amount"];
		$conditions = [
			"o.user_id" => $userId,
			"DATE(o.date) BETWEEN '$dateFrom' AND '$dateTo'" => null
		];
		$groupBy = 'o.id';
		return $this->db->select($tablename, $conditions ,true, $columns, $groupBy);
	}	


	public function userOrderProducts($orderId){

		$tablename= "order_product op JOIN product p ON op.product_id = p.id";
		$conditions= ["op.order_id" =>$orderId];
		$columns=["p.name AS product_name","p.price AS product_price","op.quantity AS product_order_quantity "];

		return $this->db->select($tablename, $conditions, true, $columns);
	}

	public function cancelOrder($id){
		$condition=['id' => $id];
		$this->db->delete("orders", $condition);
	}

	public function userChecks( $dateFrom, $dateTo) {
		$tablename = "user u JOIN orders o ON u.id = o.user_id JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id";
		$columns = ["u.id AS user_id", "u.name AS username", "SUM(p.price * op.quantity) AS total_spent"];
		$conditions = [
			"DATE(o.date) BETWEEN '$dateFrom' AND '$dateTo'" => null
		];
		$groupBy = 'u.id';
		return $this->db->select($tablename, $conditions ,true, $columns, $groupBy);
	}	


	public function userOrdersChecks($userId, $dateFrom, $dateTo) {
		$tablename = "orders o JOIN user u ON o.user_id = u.id JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id ";
		$columns = ["o.id AS order_id", "o.date AS order_date", "SUM(op.quantity * p.price) AS order_amount"];
		$conditions = [
			"o.user_id" => $userId,
			"DATE(o.date) BETWEEN '$dateFrom' AND '$dateTo'" => null
		];
		$groupBy = 'o.id';
		return $this->db->select($tablename, $conditions ,true, $columns, $groupBy);
	}	


	public function userCheck($userId, $dateFrom, $dateTo) {
		$tablename = "user u JOIN orders o ON u.id = o.user_id JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id";
		$columns = ["u.id AS user_id", "u.name AS username", "SUM(p.price * op.quantity) AS total_spent"];
		$conditions = [
			"o.user_id" => $userId,
			"DATE(o.date) BETWEEN '$dateFrom' AND '$dateTo'" => null
		];
		$groupBy = 'u.id, u.name';
		return $this->db->select($tablename, $conditions ,true, $columns, $groupBy);
	}	

	public function getAllUsers(){
		return $this->db->select("user");
	}


	public function adminProcessingOrders() {
		$tablename = "orders o JOIN user u ON o.user_id = u.id JOIN room r ON u.room_id = r.id";
		$columns = ["o.id AS order_id", "o.date AS order_date", "o.id AS user_id", "u.name AS username","r.number AS room_number","r.ext AS eoom_ext"];
		$conditions = [
			"o.status" => "Processing"		
		];
		return $this->db->select($tablename, $conditions ,true, $columns);
	}	

	public function orderTotalPrice($orderId) {
		$tablename = "orders o JOIN order_product op ON o.id = op.order_id JOIN product p ON op.product_id = p.id";
		$columns = ["SUM(p.price * op.quantity) AS total_price"];
		$conditions = [
			"o.id" => $orderId
		];
		return $this->db->select($tablename, $conditions ,true, $columns);
	}

	public function updateOrderStatus($orderId){

		$updateData = [
            'status' => "Out for delivery"
        ];
		$condition=["id"=>$orderId];
		$this->db->update("orders", $updateData, $condition) ;
	}

}

?>

