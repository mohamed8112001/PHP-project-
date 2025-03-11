<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';
include 'business_logic.php';

$database = new Database($pdo);
$db = new BusinessLogic($database);
$products = $db->get_all_products();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المنتجات</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { width: 80%; margin: auto; padding: 20px; background: #fff; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background: #007bff; color: white; }
        img.product-img { max-width: 100px; }
        .no-img { color: #999; }
        button { padding: 10px 20px; background: #007bff; border: none; color: white; cursor: pointer; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Products list </h2>
        <table>
            <tr>
                <th>Products Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Category</th>
                <th>Photo</th>
                <th>procedures</th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= $product['status'] ?></td>
                    <td><?= $product['category_name'] ?></td>
                    <td>
                        <?php if (!empty($product['image_path']) && file_exists($product['image_path'])): ?>
                            <img src="<?= $product['image_path'] ?>" class="product-img" alt="Product Image">
                        <?php else: ?>
                            <span class="no-img">There is no photo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_product.php?id=<?= $product['id'] ?>">Modifi</a> |
                        <a href="delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button onclick="window.location.href='add_product.php'">Add a new product</button>
    </div>
</body>
</html>
