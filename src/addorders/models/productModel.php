<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../entities/product.php';

class ProductModel{
    private $db;

    public function __construct($conn){
        $this->db=new Database($conn);
    }

    public function getAllProducts(){
        $records=$this->db->select("select p.id as id, p.name as name, p.price as price,p.status as status, p.image_path as image_path, c.name as category from product as p, category as c where p.category_id=c.id;");
        $products=[];
        foreach($records as $record){
            $products[] = new Product(
                $record['id'],
                $record['name'],
                $record['price'],
                $record['status'],
                $record['image_path'],
                $record['category'],
            );
        }
        return $products;
    }
}

?>