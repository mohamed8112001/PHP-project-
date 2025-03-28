<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config.php';
include 'business_logic.php';
include 'validation.php';

$database = new Database($pdo);
$db       = new BusinessLogic($database);
$error    = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['name'], $_POST['price'], $_POST['status'], $_POST['category_id'])) {
        $error = "All fields are required";
    } else {
        $name        = Validator::sanitize($_POST['name']);
        $price       = Validator::sanitize($_POST['price']);
        $status      = Validator::sanitize($_POST['status']);
        $category_id = Validator::sanitize($_POST['category_id']);

        if (!Validator::validateProductName($name)) {
            $error = "Invalid product name.";
        } elseif (!Validator::validatePrice($price)) {
            $error = "The price is invalid.";
        } elseif (!Validator::validateStatus($status)) {
            $error = "Status is invalid.";
        } elseif (!Validator::validateCategoryId($category_id)) {
            $error = "Invalid class ID.";
    
        } else {
            $image_path = '';
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['product_image']['type'], $allowed_types)) {
                    $error = "Allowed file types: JPEG, PNG, GIF.";
                } elseif ($_FILES['product_image']['size'] > 2 * 1024 * 1024) {
                    $error = "File size must be less than 2MB";
                } else {
                    $image_path = 'Images/' . basename($_FILES['product_image']['name']);
                    if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path)) {
                        $error = "An error occurred while uploading the product image.";
                    }
                }
            }
            if (empty($error)) {
                $inserted = $db->addProduct($name, $price, $category_id, $status, $image_path);
                if ($inserted) {
                    header("Location: index.php?success=1");
                    exit();
                } else {
                    $error = "An error occurred while adding the product";
                }
            }
        }
    }
}

include 'templates/header.php';
?>
<div class="container">
    <h2>حفظ المنتج</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <a href="add_product.php">العودة لإضافة منتج جديد</a>
</div>
<?php include '../template/footer.php'; ?>
