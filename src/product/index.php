<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config.php';
include 'business_logic.php';

$database = new Database();
$db = new BusinessLogic($database);
$products = $db->get_all_products();
include_once('../template/nav.php');
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="templates/styleTemplate.css">
</head>
<body style="background-color: var(--light);">
    <div class="container mt-5">
        <div class="card shadow-lg" style="background: var(--light); border: 2px solid var(--primary);">
            <div class="card-header text-white text-center" style="background: var(--primary);">
                <h2>Products List</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead class="text-white" style="background: var(--primary);">
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Photo</th>
                            <th>Procedures</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?= $product['name'] ?></td>
                                <td><?= $product['price'] ?></td>
                                <td><?= $product['status'] ?></td>
                                <td><?= $product['category_name'] ?></td>
                                <td>
                                    <?php if (!empty($product['image_path']) && file_exists($product['image_path'])): ?>
                                        <img src="<?= $product['image_path'] ?>" class="product-img" alt="Product Image" style="width: 100px; border-radius: 10px;">
                                    <?php else: ?>
                                        <span class="text-muted">No Photo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">Modify</a>
                                    <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-center mt-3">
                    <button onclick="window.location.href='add_product.php'" class="btn btn-secondary text-white" style="background: var(--secondary); border-color: var(--secondary);">
                        <i class="fas fa-plus"></i> Add a New Product
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>