<?php
class Product {
    public $id;
    public $name;
    public $location;
    public $capacity;

    public function __construct($id, $name, $location, $capacity) {
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->capacity = $capacity;
    }
}
?>