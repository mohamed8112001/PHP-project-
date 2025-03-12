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
    <nav>
        <a href="index.php" class="btn">Products</a> |
        <a href="add_product.php" class="btn">Add a Product</a> |
        <a href="addCategory.php" class="btn btn-secondary">Add New Category</a>
    </nav>

    <h2>Add a New Product</h2>

    <form action="save_product.php" method="POST" enctype="multipart/form-data" class="product-form">
        <label>Product Name:</label>
        <input type="text" name="name" required placeholder="Enter product name"><br>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" required placeholder="Enter price"><br>

        <label>Status:</label>
        <select name="status" required>
            <option value="available">Available</option>
            <option value="unavailable">Not Available</option>
        </select><br>

        <label>Category:</label>
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <a href="addCategory.php" class="add-category-link">+ Add New Category</a><br>

        <label>Product Image:</label>
        <input type="file" name="product_image"><br>

        <button type="submit" class="btn btn-primary">Save Product</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>

<style>
    .container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    nav {
        margin-bottom: 15px;
    }

    .btn {
        display: inline-block;
        padding: 8px 15px;
        text-decoration: none;
        color: white;
        background: #007bff;
        border-radius: 5px;
    }

    .btn-secondary {
        background: #28a745;
    }

    .product-form label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }

    .product-form input, .product-form select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .product-form button {
        margin-top: 15px;
        padding: 10px;
        width: 100%;
        border: none;
        background: #007bff;
        color: white;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    .product-form button:hover {
        background: #0056b3;
    }

    .add-category-link {
        display: inline-block;
        margin-top: 5px;
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
    }

    .add-category-link:hover {
        text-decoration: underline;
    }
</style>
