<?php
require_once __DIR__ . '/../models/roomModel.php';
require_once __DIR__ . '/../includes/connector.php';

class RoomController {
    private $roomModel;

    public function __construct(){
        global $conn;
        $this->roomModel = new RoomModel($conn);
    }

    public function getAllRooms(){
        // session_start();
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: login.php');
        //     exit();
        // }
        
        // $userId = $_SESSION['user_id'];
        $rooms=$this->roomModel->getAllRooms();
        return $rooms;   
    }
}

?>