<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once('../database.php');

class BusinessLogic {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }
    public function addProduct($name, $price, $category_id, $status = 'available', $image_path = null) {
        $data = [
            'name'  => $name,
            'price'=> $price,
            'status'=> $status,
            'category_id'=> $category_id
        ];

        if ($image_path) {
            $data['image_path'] = $image_path;
        }

        return $this->db->insert('product',['name','price','category_id','image_path','status'],[$name, $price, $category_id,$image_path,$status = 'available' ]);
    }

    public function get_all_products() {
        $sql = "SELECT product.*, category.name AS category_name 
                FROM product 
                LEFT JOIN category ON product.category_id = category.id";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_product_by_id($id) {
        $result = $this->db->select('product', ['id' => $id]);
        return isset($result[0]) ? $result[0] : null;
    }

    public function update_product($id, $name, $price, $category_id, $status, $image_path = null) {
        $data = [
            'name'=> $name,
            'price'=> $price,
            'status'=> $status,
            'category_id'=> $category_id
        ];

        if ($image_path !== null) {
            $data['image_path'] = $image_path;
        }

        return $this->db->update('product', $data, ['id' => $id]);
    }

    public function delete_product($id) {
        return $this->db->delete('product', ['id' => $id]);
    }

    // public function check_product_name_exists($name) {
    //     $result = $this->db->select('product', ['name' => $name], 'COUNT(*) as count');
    //     return $result[0]['count'] > 0;
    // }

    public function get_all_categories() {

        return $this->db->select('category');
    }

    
}
class Category {
    private $db;

    // Constructor to inject the database connection
    // public function __construct($db) {
    //     $this->db = $db;
    // }
    public function __construct() {
        $this->db = new Database();
    }


    public function insertCategory($name) {
        return $this->db->insert('`category`', ['name'], [$name]);
    }
}
?>