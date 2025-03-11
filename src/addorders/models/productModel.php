<?php
require_once __DIR__ . '/../includes/database.php';

class ProdcutModel{
    private $db;

    public function __construct($conn){
        $this->db=new Database($conn);
    }

    public function getAllProducts(){
        $records=$this->db->select("select * from product as p, category as c where p.category_id=c.id;");
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
    }
}

?>