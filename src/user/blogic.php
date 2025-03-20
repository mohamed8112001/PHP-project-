<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once('../database.php');

class User { 
    private $db; 

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllRooms() {
        return $this->db->select('room');
    }

    public function getAllUsers() {
        return $this->db->select('`user`'); 
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


    public function insert_user($name, $email, $password, $profile_picture, $room_no, $role = "user") {
        return $this->db->insert('`user`',['name', 'email', 'password', 'image_path', 'room_id', 'role'],[$name, $email, $password, $profile_picture, $room_no, $role]);

    }
// $tablename, $conditions = [], $fetchAll = true, $columns = [], $groupBy = ''
    // public function login( $email, $password) {
    //     return $this->db->select('user',"where email=? and password=?");

    // }
    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            return false; // التأكد من أن البيانات ليست فارغة
        }
    
        // تنفيذ الاستعلام في قاعدة البيانات
        $result = $this->db->select('user', "WHERE email = ? AND password = ?", [$email, $password]);
        
        if ($result) {
            // لو لقى النتيجة، يرجع بيانات المستخدم
            return $result[0];
        } else {
            return false; // لو البيانات غلط
        }
    }
   
    
}

class Category {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }


    public function insertCategory($name) {
        return $this->db->insert('`category`', ['name'], [$name]);
    }
}
?>



