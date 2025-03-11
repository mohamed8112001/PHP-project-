<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once('database.php');

class User { 
    private $db; 

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllRooms() {
        return $this->db->select('room');
    }

    public function getAllUsers() {
        return $this->db->select('`user`'); // Backticks prevent reserved keyword issue
    }

    public function getUserById($id) {
        return $this->db->select('`user`', ['id' => $id], false);
    }

    public function updateUser($updateData, $id) {
        return $this->db->update('`user`', $updateData, ['id' => $id]);
    }

    public function deleteUser($id) {
        return $this->db->delete('`user`',['id' => $id]  );
    }

    public function insert_room($room_no,$ext) {
        return $this->db->insert('`room`',['number','ext'],[$room_no, $ext]);
    }
    // public function insert_user($name, $email, $password, $profile_picture, $room_no, $role = 'user') {
    //     $stmt = $this->db->getConnection()->prepare(
    //         "INSERT INTO `user` (name, email, password, image_path, room_id, role) VALUES (?, ?, ?, ?, ?, ?)"
    //     );
    //     return $stmt->execute([$name, $email, $password, $profile_picture, $room_no, $role]);
    //     // return $this->db->insert('`user`',['name', 'email', 'password', 'image_path', 'room_id', 'role'],[$name, $email, $password, $profile_picture, $room_no, $role]);
    // }

    public function insert_user($name, $email, $password, $profile_picture, $room_no, $role = "user") {
        // try {
        //     $stmt = $this->db->getConnection()->prepare(
        //         query: "INSERT INTO `user` (name, email, password, image_path, room_id, role) VALUES (?, ?, ?, ?, ?, ?)"
        //         // 'INSERT INTO `user` (name, email, password, image_path, room_id, role) VALUES ("Mustafamohamed","mustafass@gmail.com","Mohamessd@8112001","dssd",1111,"user")'
        //     );
        //     $stmt->execute([$name, $email, $password, $profile_picture, $room_no, $role]);
        //     echo "User inserted successfully!";
        // } catch (PDOException $e) {
        //     die("Insert failed: " . $e->getMessage());
        // }
        return $this->db->insert('`user`',['name', 'email', 'password', 'image_path', 'room_id', 'role'],[$name, $email, $password, $profile_picture, $room_no, $role]);

    }
   
    // public function insert_room($room_no, $ext) {
    //     // Ensure room number is not empty or duplicate
    //     if (empty($room_no)) {
    //         throw new Exception("Error: Room number cannot be empty.");
    //     }
    
    //     // Check if the room number already exists
    //     $stmt = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM `room` WHERE `number` = ?");
    //     $stmt->execute([$room_no]);
    //     $count = $stmt->fetchColumn();
    
    //     if ($count > 0) {
    //         throw new Exception("Error: Room number already exists.");
    //     }
    
    //     // Proceed with insertion
    //     $stmt = $this->db->getConnection()->prepare(
    //         "INSERT INTO `room` (number, ext) VALUES (?, ?)"
    //     );
    //     return $stmt->execute([$room_no, $ext]);
    // }
    
    
    // public function insert_room($room_no,$ext) {
    //     $stmt = $this->db->getConnection()->prepare(
    //         "INSERT INTO `room` (number, ext) VALUES (?, ?)"
    //     );
    //     return $stmt->execute([$room_no, $ext]);
    // }
}

class Category {
    private $db;

    // Constructor to inject the database connection
    // public function __construct($db) {
    //     $this->db = $db;
    // }
    public function __construct() {
        $this->db = new Database();
    }


    public function insertCategory($name) {
        return $this->db->insert('`category`', ['name'], [$name]);
    }
}
?>



