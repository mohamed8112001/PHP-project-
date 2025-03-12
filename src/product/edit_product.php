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
include 'templates/header.php';
?>
<div class="container">
    <h2>Modify the product</h2>
    <form action="update_product.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <input type="text" name="name" required placeholder="Product Name" value="<?= $product['name'] ?>">
        <input type="number" name="price" step="0.01" required placeholder="the price" value="<?= $product['price'] ?>">
        <select name="status" required>
            <option value="available" <?= $product['status'] == 'available' ? 'selected' : '' ?>>Available</option>
            <option value="unavailable" <?= $product['status'] == 'unavailable' ? 'selected' : '' ?>>Not available</option>
        </select>
        
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Current image:</label>
        <?php if (!empty($product['image_path']) && file_exists($product['image_path'])): ?>
            <img src="<?= $product['image_path'] ?>" class="product-img" alt="Product Image">
        <?php else: ?>
            <span>No image</span>
        <?php endif; ?>
        <input type="file" name="product_image">
        <button type="submit">Product update</button>
    </form>
</div>
<?php include 'templates/footer.php'; ?>
