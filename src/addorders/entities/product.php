<?php

class Product {
    public $name;
    public $id;
    public $price;
    public $status;
    public $imagePath;
    public $category;
    
    public function __construct($id
    ,$name
    ,$price
    ,$status
    ,$imagePath
    ,$category){
        $this->id=$id;
        $this->name=$name;
        $this->price=$price;
        $this->status=$status;
        $this->imagePath=$imagePath;
        $this->category=$category;

    }
}

?>