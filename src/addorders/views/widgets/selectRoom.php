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
    <title>AddToUser</title> 
</head>
<body>
    <div class="mb-4 form-group">
        <label class="form-label">Room</label>
        <select class="dropdown-select">
            <?php 
                require_once 'controllers/roomController.php';
                $roomController = new RoomController();
                $rooms = $roomController->getAllRooms();
                foreach($rooms as $room){
                    print_r($room);
                    echo '<option value="' . $room->id . '" >' . $room->number  . ': ' . $room->ext .'</option>';   
                }

            ?>
        </select>
    </div>
</body>
</html>