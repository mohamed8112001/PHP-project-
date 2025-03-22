<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Selection</title> 
</head>
<body>
    <div class="mb-4 form-group">
        <label class="form-label">Room</label>
        <select class="dropdown-select" name="room_id" id="room_id" required>
            <option value="">-- Select a Room --</option>
            <?php 
                require_once 'controllers/roomController.php';
                $roomController = new RoomController();
                $rooms = $roomController->getAllRooms();
                print("rooms: ");
                print_r($rooms);
                
                foreach($rooms as $room) {
                    echo '<option value="' . $room->id . '">' . $room->number . ': ' . $room->ext . '</option>';   
                }
            ?>
        </select>
    </div>
</body>
</html>