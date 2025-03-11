<?php
class Product {
    public $name;
    public $id;
    public $price;
    public $status;
    public $image_path;
    public $category;
    
    public function __construct($name
    ,$id
    ,$price
    ,$status
    ,$image_path
    ,$category){
        $this->id=$id;
        $this->name=$name;
        $this->price=$price;
        $this->status=$status;
        $this->image_path=$image_path;
        $this->category=$category;

    }
}

?>