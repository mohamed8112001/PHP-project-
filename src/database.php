<?php
include_once('config.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Database {
    public $pdo;
    public function __construct() {
        global $host, $database, $username, $password; // Ensure these variables exist in config.php
        
        try {
            $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo; // Return the PDO instance
    }
   
    public function delete($tablename, $conditions) {
        global $pdo;
        
        // Build the WHERE clause dynamically
        $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($conditions)));
    
        // Prepare the SQL statement
        $sql = "DELETE FROM $tablename WHERE $whereClause";
        $stmt = $pdo->prepare($sql);
    
        // Execute the statement with the provided parameters
        $stmt->execute($conditions);
    
        return $stmt->rowCount(); // Return the number of rows affected
    }

    // public function select($tablename, $conditions = [], $fetchAll = true) {

    //     try {
    //         $sql = "SELECT * FROM $tablename";
    //         if (!empty($conditions)) {
    //             $whereClauses = [];
    //             foreach ($conditions as $column => $value) {
    //                 $whereClauses[] = "$column = :$column";
    //             }
    //             $sql .= " WHERE " . implode(" AND ", $whereClauses);
    //         }
    //         $stmt = $this->pdo->prepare($sql);
    //         $stmt->execute($conditions);
    //         return $fetchAll ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         return "Error in select: " . $e->getMessage();
    //     }
    // }

    public function select($tablename, $conditions = [], $fetchAll = true, $columns = [], $groupBy = '') {
        try {
            $columnsStr = !empty($columns) ? implode(", ", $columns) : '*';
            $sql = "SELECT $columnsStr FROM $tablename";
            $params = [];
            if (!empty($conditions)) {
                $whereClauses = [];
                $params = [];
                $counter = 1; // Ensures unique placeholders
            
                foreach ($conditions as $column => $value) {
                    if (is_null($value)) {
                        $whereClauses[] = "$column";
                    }else {
                        $paramName = ":param$counter";
                        $whereClauses[] = "$column = $paramName";
                        $params[$paramName] = $value;
                        $counter++;
                    }
                }
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }
            if ($groupBy) {
                $sql .= " GROUP BY $groupBy";
            }
       
            $stmt = $this->pdo->prepare($sql);            
            $stmt->execute($params);
    
            return $fetchAll ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error in select: " . $e->getMessage();
        }
    }


    public function insert($tablename, $columns, $values) {
        if (count($columns) !== count($values)) {
            throw new Exception("Number of columns does not match number of values.");
        }

        $placeholders = array_map(fn($col) => ":$col", $columns);
        $columnsStr = implode(', ', $columns);
        $placeholdersStr = implode(', ', $placeholders);

        $sql = "INSERT INTO $tablename ($columnsStr) VALUES ($placeholdersStr)";
        $stmt = $this->pdo->prepare($sql);

        $params = array_combine($placeholders, $values);
        $stmt->execute($params);
        
        return $stmt->rowCount();
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

// class Category{
//     public $pdo;
//     public function __construct() {
//         global $host, $database, $username, $password; // Ensure these variables exist in config.php
        
//         try {
//             $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
//             $this->pdo = new PDO($dsn, $username, $password);
//             $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch (PDOException $e) {
//             die("Database connection failed: " . $e->getMessage());
//         }
//     }

//     public function getConnection() {
//         return $this->pdo; // Return the PDO instance
//     }
//     public function select($tablename, $conditions = [], $fetchAll = true) {

//         try {
//             $sql = "SELECT * FROM $tablename";
//             if (!empty($conditions)) {
//                 $whereClauses = [];
//                 foreach ($conditions as $column => $value) {
//                     $whereClauses[] = "$column = :$column";
//                 }
//                 $sql .= " WHERE " . implode(" AND ", $whereClauses);
//             }
//             $stmt = $this->pdo->prepare($sql);
//             $stmt->execute($conditions);
//             return $fetchAll ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
//         } catch (PDOException $e) {
//             return "Error in select: " . $e->getMessage();
//         }
//     }
//     public function insert($tablename, $columns, $values) {
//         if (count($columns) !== count($values)) {
//             throw new Exception("Number of columns does not match number of values.");
//         }

//         $placeholders = array_map(fn($col) => ":$col", $columns);
//         $columnsStr = implode(', ', $columns);
//         $placeholdersStr = implode(', ', $placeholders);

//         $sql = "INSERT INTO $tablename ($columnsStr) VALUES ($placeholdersStr)";
//         $stmt = $this->pdo->prepare($sql);

//         $params = array_combine($placeholders, $values);
//         $stmt->execute($params);

//         return $stmt->rowCount();
//     }
// }

?>  
