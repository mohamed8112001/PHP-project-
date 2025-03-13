<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config.php';
include 'business_logic.php';
include 'validation.php';
$database = new Database($pdo);
$db = new BusinessLogic($database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['id'], $_POST['name'], $_POST['price'], $_POST['status'], $_POST['category_id'])) {
        die("All fields are required");
    }
    
    $id = $_POST['id'];
    $name= Validator::sanitize($_POST['name']);
    $price= Validator::sanitize($_POST['price']);
    $status= Validator::sanitize($_POST['status']);
    $category_id = Validator::sanitize($_POST['category_id']);
    
    $current_product = $db->get_product_by_id($id);
    if (!$current_product) {
        die("Product not found");
    }

    
    $product_image = $current_product['image_path'];
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['product_image']['type'], $allowed_types)) {
            die("Invalid file type");
        }
        
        $new_image = 'Images/' . basename($_FILES['product_image']['name']);
        if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $new_image)) {
            die("An error occurred while uploading the product image.");
        }
        $product_image = $new_image;
    }
    
    $updated = $db->update_product($id, $name, $price, $category_id, $status, $product_image);
    if ($updated) {
        header("Location: index.php");
        exit();
    } else {
        echo "An error occurred while updating the product!";
    }
} else {
    die("Invalid request");
}
?>
