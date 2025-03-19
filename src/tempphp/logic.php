<?php
include_once("mysqlconnection.php");

class Query_database
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertData($table, $data)
    {
        try {

            if (!in_array($table, ['User'])) {
                throw new Exception("Invalid table name");
            }

            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_map(fn($key) => ":$key", array_keys($data)));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute($data);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function updateUser($UserID, $data)
    {
        try {
            $setPart = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
            $sql = "UPDATE User SET $setPart WHERE ID = :UserID";
            $stmt = $this->pdo->prepare($sql);
            $data['UserID'] = $UserID;
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

//    public function deleteUser($UserID)
//     {
//         try {
//             $stmt = $this->pdo->prepare("DELETE FROM User WHERE ID = :UserID");
//             $stmt->execute(['UserID' => $UserID]);
//             return $stmt->rowCount() > 0;
//         } catch (PDOException $e) {
//             return "Error: " . $e->getMessage();
//         }
//     }

    public function getUserByID($UserID)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM User WHERE ID = :UserID");
            $stmt->execute(['UserID' => $UserID]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // public function getAllUsers()
    // {
    //     try {
    //         $stmt = $this->pdo->query("SELECT * FROM User");
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    public function getUserByEmailOrUsername($input)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT ID, Username, email, password_hash, Role FROM User WHERE email = :input OR Username = :input");
            $stmt->execute(['input' => $input]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // public function getUsersCount()
    // {
    //     try {
    //         $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM User");
    //         return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    //     } catch (PDOException $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }


    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM User WHERE email = :email");
            $stmt->execute(['email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function saveResetToken($email, $token)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE User SET reset_token = :token, token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email");
            return $stmt->execute(['token' => $token, 'email' => $email]);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getEmailByToken($token)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT email FROM User WHERE reset_token = :token AND token_expiry > NOW()");
            $stmt->execute(['token' => $token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['email'] : false;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function updatePassword($email, $hashedPassword)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE User SET password = :password, reset_token = NULL, token_expiry = NULL WHERE email = :email");
            return $stmt->execute(['password' => $hashedPassword, 'email' => $email]);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
