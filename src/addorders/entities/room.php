<?php
class Room {
    public $id;
    public $number;
    public $ext;

    public function __construct($id, $number, $ext) {
        $this->id = $id;
        $this->number = $number;
        $this->ext = $ext;
    }
}
?>