<?php
require_once __DIR__ . '/../entities/user.php';
require_once __DIR__ . '/../includes/database.php';

class UserModel{
    private $db;

    public function __construct($conn){
        $this->db= new Database($conn);
    }

    public function getAllUsers(){
        $records=$this->db->selectAll("user");
        $users=[];
        foreach($records as $record){
            $users[] = new  User($record['id'], $record['name'], $record['email'], $record['password'], $record['image_path'], $record['role'], $record['room_id']);
        }
        return $users;
    }

    public function findUserById($email){
        $users=$this->db->select('select * from user where email=:email', [':email'=>$email]);
        if (count($users) == 0) return null;
        $record = $users[0];
        return new User($record['id'], $record['name'], $record['email'], $record['password'], $record['image_path'], $record['role'], $record['room_id']);
    }
}

?>

