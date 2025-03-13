<?php


class Order{
    public $id;
    public $date;
    public $status;
    public $notes;
    public $user_id;
    public $room_id;


    public function __construct($id, $date, $status, $notes, $user_id, $room_id){
        $this->id=$id;
        $this->date=$date;
        $this->status=$status;
        $this->notes=$notes;
        $this->room_id=$room_id;
        $this->user_id=$user_id;
    }
}

?>
