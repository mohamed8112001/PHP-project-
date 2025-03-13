<?php

require_once __DIR__ . '/../models/userModel.php';
require_once __DIR__ . '/../models/roomModel.php';
require_once __DIR__ . '/../includes/connector.php';

class UserController {
    private $userModel;
    private $roomModel;

    public function __construct(){
        global $conn;
        $this->userModel = new UserModel($conn);
        $this->roomModel = new RoomModel($conn);
    }

    public function getCurrentUser(){
        // session_start();
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: login.php');
        //     exit();
        // }
        
        // $userId = $_SESSION['user_id'];
        $user=$this->userModel->findUserById(
            "moataz.noaman12@gmail.com"
        );
        return $user;   
    }

    public function getAllUsers(){
        // session_start();
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: login.php');
        //     exit();
        // }
        
        // $userId = $_SESSION['user_id'];
        $users=$this->userModel->getAllUsers();
        return $users;
    }
}

?>