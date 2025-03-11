<?php
require_once 'Database.php';

class BusinessLogic {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }
    public function addProduct($name, $price, $category_id, $status = 'available', $image_path = null) {
        $data = [
            'name'        => $name,
            'price'       => $price,
            'status'      => $status,
            'category_id' => $category_id
        ];

        if ($image_path) {
            $data['image_path'] = $image_path;
        }

        return $this->db->insert('product', $data);
    }

    public function get_all_products() {
        $sql = "SELECT product.*, category.name AS category_name 
                FROM product 
                LEFT JOIN category ON product.category_id = category.id";
        return $this->db->query($sql)->fetchAll();
    }

    public function get_product_by_id($id) {
        $result = $this->db->select('product', ['id' => $id]);
        return isset($result[0]) ? $result[0] : null;
    }

    public function update_product($id, $name, $price, $category_id, $status, $image_path = null) {
        $data = [
            'name'        => $name,
            'price'       => $price,
            'status'      => $status,
            'category_id' => $category_id
        ];

        if ($image_path !== null) {
            $data['image_path'] = $image_path;
        }

        return $this->db->update('product', $data, ['id' => $id]);
    }

    public function delete_product($id) {
        return $this->db->delete('product', ['id' => $id]);
    }

    public function check_product_name_exists($name) {
        $result = $this->db->select('product', ['name' => $name], 'COUNT(*) as count');
        return $result[0]['count'] > 0;
    }

    public function get_all_categories() {
        return $this->db->select('category');
    }
}
?>
