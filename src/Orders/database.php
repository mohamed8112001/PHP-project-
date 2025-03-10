<?php
include_once('config.php');

class Database
{
	private $config;
	private $conn;
	public function __construct()
	{
		try {
			$this->config= new Config("localhost", "nada", "123456", "Cafeteria");
			$this->conn = new PDO("mysql:host=" . $this->config->getHost() . ";dbname=" . $this->config->getDatabase() , $this->config->getUser(), $this->config->getPassword());
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
    			die( "Connection failed: " . $e->getMessage());
		}
	}
		
	
	public function select($sql,$param =[])
	{
		try {
			$stmt = $this->conn->prepare($sql);
			foreach ($param as $key => $value )
			{
				$stmt->bindValue($key, $value, is_int($value)? PDO::PARAM_INT : PDO::PARAM_STR);
			}
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $e) {
			die("Database Error: " . $e->getMessage()); // Show the error
			error_log("Database Error: " . $e->getMessage());
            return [];
		}
	}
	
	function delete($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";
        $this->conn->exec($sql);        
    }


	function selectAll($table)
    {	        
        $stmt = $this->conn->prepare("SELECT * FROM $table");
        $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }	

}

?>

