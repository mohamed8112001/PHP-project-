<?php

include("mysqlconnection.php");

class Functions
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertData($table, $data)
    {
        try {
            $sql = "INSERT INTO $table (" . implode(", ", array_keys($data)) . ") VALUES (:" . implode(", :", array_keys($data)) . ")";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function updateUser($UserID, $Username, $Email, $First_name, $Last_name, $phone, $profile_image, $Gender, $Role)
    {
        try {
            $sql = "UPDATE User 
                    SET Username = :Username, email = :Email, First_name = :First_name, 
                        Last_name = :Last_name, Phone_number = :phone, 
                        profile_image = :profile_image, gender = :Gender, Role = :Role
                    WHERE id = :UserID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':UserID'           => $UserID,
                ':Username'         => $Username,
                ':Email'            => $Email,
                ':First_name'       => $First_name,
                ':Last_name'        => $Last_name,
                ':phone'            => $phone,
                ':profile_image'    => $profile_image,
                ':Gender'           => $Gender,
                ':Role'             => $Role
            ]);
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function deleteUser($UserID)
    {
        try {
            $sql = "DELETE FROM User WHERE ID = :UserID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':UserID' => $UserID]);
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getUserByID($UserID)
    {
        try {
            $sql = "SELECT * FROM User WHERE ID = :UserID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':UserID' => $UserID]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getAllUsers()
    {
        try {
            $sql = "SELECT * FROM User";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getUserByEmailOrUsername($input)
    {
        try {
            $sql = "SELECT ID, Username, email, password_hash, Role FROM User WHERE email = ? OR Username = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$input, $input]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
