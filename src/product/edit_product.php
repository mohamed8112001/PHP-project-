<?php
session_start();
include 'config.php';
include 'business_logic.php';
include 'validation.php';

$database = new Database($pdo);
$db       = new BusinessLogic($database);

if (!isset($_GET['id'])) {
    die("Invalid request");
}
$id = $_GET['id'];
$product = $db->get_product_by_id($id);
if (!$product) {
    die("Product not available");
}
$categories = $db->get_all_categories();
include 'templates/nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="templates/styleTemplate.css">
</head>
<body style="background-color: var(--light);">
    <div class="container mt-5">
        <div class="card shadow-lg" style="background: var(--light); border: 2px solid var(--primary);">
            <div class="card-header text-white text-center" style="background: var(--primary);">
                <h2>Modify the Product</h2>
            </div>
            <div class="card-body">
                <form action="update_product.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label text-dark">Product Name:</label>
                        <input type="text" name="name" class="form-control" required value="<?= $product['name'] ?>" style="border-color: var(--primary);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Price:</label>
                        <input type="number" name="price" class="form-control" step="0.01" required value="<?= $product['price'] ?>" style="border-color: var(--primary);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Status:</label>
                        <select name="status" class="form-select" required style="border-color: var(--primary);">
                            <option value="available" <?= $product['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                            <option value="unavailable" <?= $product['status'] == 'unavailable' ? 'selected' : '' ?>>Not available</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Category:</label>
                        <select name="category_id" class="form-select" required style="border-color: var(--primary);">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                    <?= $category['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Current Image:</label><br>
                        <?php if (!empty($product['image_path']) && file_exists($product['image_path'])): ?>
                            <img src="<?= $product['image_path'] ?>" class="img-thumbnail" alt="Product Image" style="width: 150px;">
                        <?php else: ?>
                            <span class="text-muted">No Image</span>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Upload New Image:</label>
                        <input type="file" name="product_image" class="form-control" style="border-color: var(--primary);">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary text-white" style="background: var(--secondary); border-color: var(--secondary);">
                            <i class="fas fa-save"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>