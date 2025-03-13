<?php
require_once __DIR__ . '/../entities/room.php';
require_once __DIR__ . '/../includes/database.php';

class RoomModel {
    private $db;

    public function __construct($conn) {
        $this->db = new Database($conn);
    }


    public function getAllRooms() {
        $records = $this->db->selectAll("room");
        $rooms = [];
        foreach ($records as $record) {
            $rooms[] = new Room(
                $record['id'],
                $record['number'],
                $record['ext'],
            );
        }
        return $rooms;
    }

    public function getRoomById($id) {
        $rooms = $this->db->select('SELECT * FROM room WHERE id = :id', [':id' => $id]);
        if (count($rooms) > 0) {
            $record = $rooms[0];
            return new Room(
                $record['id'],
                $record['number'],
                $record['ext'],
            );
        }
        return null;
    }
}
?>