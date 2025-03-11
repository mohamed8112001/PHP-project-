<?php
require_once __DIR__ . '../entities/user.php';


class UserModel{
    private $db;

    public function __construct($conn){
        $this->db= new Database($conn);
    }

    public function getAllUsers(){
        $users=$this->db->selectAll("users");
        $users=[];
        foreach($users as $record){
            $users[] = new  User($record['id'], $record['name'], $record['email'], $record['password'], $record['image_path'], $record['role'], $record['room_id']);
        }
        return $users;
    }

    public function findUserById($email){
        $users=$this->db->select('select * from users where email=:email', [':email'=>$email]);
        $record = $users[0];
        return new User($record['id'], $record['name'], $record['email'], $record['password'], $record['image_path'], $record['role'], $record['room_id']);
    }
}

?>

