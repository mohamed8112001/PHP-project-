<?php
class Database {
    
    protected $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt = $this->pdo->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function select($table, $conditions = [], $columns = '*') {
        $sql = "SELECT $columns FROM $table";
        $params = [];
        
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = ?";
                $params[] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function update($table, $data, $conditions) {
        $set = [];
        $params = [];
        
        foreach ($data as $key => $value) {
            $set[] = "$key = ?";
            $params[] = $value;
        }
        
        $where = [];
        foreach ($conditions as $key => $value) {
            $where[] = "$key = ?";
            $params[] = $value;
        }
        
        $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE " . implode(' AND ', $where);
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($table, $conditions) {
        $where = [];
        $params = [];
        
        foreach ($conditions as $key => $value) {
            $where[] = "$key = ?";
            $params[] = $value;
        }
        
        $sql = "DELETE FROM $table WHERE " . implode(' AND ', $where);
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
?>