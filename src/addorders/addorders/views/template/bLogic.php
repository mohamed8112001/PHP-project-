<?php
include_once(  '/var/www/html/php_pro/src/database.php');

class Nav 
{
	private $db; 

    public function __construct() {
        $this->db = new Database();
    }


	public function getUserById($userId){

		$tablename= "user";
		$conditions= ["id" =>$userId];

		return $this->db->select($tablename, $conditions, false);
	}

}

?>

