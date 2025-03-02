<?php
include_once('config.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Database {
    public $pdo;

    public function __construct() {
        global $host, $database, $username, $password;
        $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Failed in connection: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }

    public function select($tablename, $conditions = [], $fetchAll = true) {
        try {
            $sql = "SELECT * FROM $tablename";
            if (!empty($conditions)) {
                $whereClauses = [];
                foreach ($conditions as $column => $value) {
                    $whereClauses[] = "$column = :$column";
                }
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($conditions);
            return $fetchAll ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error in select: " . $e->getMessage();
        }
    }

    public function insert($table, $columns, $values) {
        try {
            $colNames = implode(", ", $columns);
            $placeholders = implode(", ", array_fill(0, count($values), "?"));
            $sql = "INSERT INTO $table ($colNames) VALUES ($placeholders)";
            
            echo "SQL Query: $sql<br>";
            echo "Values: " . implode(", ", $values) . "<br>";

            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($values);

            if ($result) {
                return $stmt->rowCount();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error in insert: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function update($table, $data, $where) {
        try {
            $fields = [];
            $values = [];
    
            foreach ($data as $column => $value) {
                $fields[] = "$column = ?";
                $values[] = $value;
            }
    
            $setClause = implode(', ', $fields);
    
            $whereClause = [];
            foreach ($where as $column => $value) {
                $whereClause[] = "$column = ?";
                $values[] = $value;
            }
    
            $whereClauseString = implode(' AND ', $whereClause);
    
            $sql = "UPDATE $table SET $setClause WHERE $whereClauseString";
            $stmt = $this->pdo->prepare($sql);
    
            return $stmt->execute($values);
        } catch (PDOException $e) {
            die("error in update " . $e->getMessage());
        }
    }
}
?>  
