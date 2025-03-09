
<?php
include_once('blogic.php');

$user = new User();
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $room_no = $_POST['room-no'] ?? '';
    $ext = $_POST['ext'] ?? '';
    var_dump($room_no);
    var_dump($ext);

    $user->insert_room($room_no,$ext);
}

?>