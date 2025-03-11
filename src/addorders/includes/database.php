<?php
include_once( __DIR__.'/../config/config.php');


class Database{
	private $conn;
	public function __construct($conn)
	{
		$this->conn=$conn;
	}
	
	public function insert($table, $values){
		try{
			$stmt=$this->conn->prepare("insert into ".$table." values(".$values.");");
			$stmt->execute();
		}catch(PDOException $e){
			die("Database Error: " . $e->getMessage());
			error_log("Database Error: " . $e->getMessage());
            return [];
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


	public function update($table, $columns, $values, $condition)
	{
		if(count($values)==count($columns)+1)
		{	
			$setClause = implode(" = ?, ", $columns) . " = ?";		
			$sql = "UPDATE $table SET $setClause WHERE $condition";
			$stmt = $this->conn->prepare($sql);        	       
			$stmt->execute($values)  ;   		
		}else{
			echo "Number of columns and values are not identical.<br>";
		}
	}

}

?>

