<?php
class User{

    public $id;
    public $name;
    public $email;
    public $password;
    public $image_path;
    public $role;
    public $room_id;

    public function __construct($id, $name, $email, $password, $image_path, $role, $room_id){
        $this->id=$id;
        $this->name=$name;
        $this->email=$email;
        $this->password=$password;
        $this->image_path=$image_path;
        $this->role=$role;
        $this->room_id=$room_id;
    }
}

?>