<?php
require_once __DIR__ . '/../models/productModel.php';
require_once __DIR__ . '/../includes/connector.php';

class ProductController {
    private $productModel;

    public function __construct() {
        global $conn;
        $this->productModel = new ProductModel($conn);
    }

    public function getAllProduct() {
        // session_start();
        // if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        //     header('Location: login.php');
        //     exit();
        // }
        
        $products = $this->productModel->getAllProducts();
        return $products;
    }
}
?>