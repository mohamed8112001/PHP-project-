<?php
session_start();
include 'config.php';
include 'business_logic.php';
$database   = new Database($pdo);
$db  = new BusinessLogic($database);
$categories = $db->get_all_categories();
include 'templates/header.php';
?>
<div class="container">
<a href="index.php">products</a> |
<a href="add_product.php">Add a product</a>
    <h2>Add a new product</h2>

    <form action="save_product.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" required placeholder="Product Name"><br><br>
        <input type="number" name="price" step="0.01" required placeholder="Price"><br>
        <select name="status" required>
            <option value="available">Available</option><br>
            <option value="unavailable">Not available</option><br>
        </select>
        <select name="category_id" required> <br>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="file" name="product_image"><br>
        <button type="submit">Save the product</button>
    </form>
</div>
<?php include 'templates/footer.php'; ?>
