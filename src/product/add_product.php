<?php
session_start();
include 'config.php';
include 'business_logic.php';
$database  = new Database($pdo);
$db  = new BusinessLogic($database);
$categories = $db->get_all_categories();
include '../template/nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="templates/styleTemplate.css">
</head>
<body style="background-color: var(--light);">
    <div class="container mt-5">
        <nav class="mb-4 text-center">
            <a href="index.php" class="btn btn-primary" style="background: var(--primary); border-color: var(--primary);">Products</a>
            <a href="add_product.php" class="btn btn-secondary" style="background: var(--secondary); border-color: var(--secondary);">Add a Product</a>
            <a href="addCategory.php" class="btn btn-warning" style="background: var(--secondary); border-color: var(--secondary);">Add New Category</a>
        </nav>
        <div class="card shadow-lg" style="background: var(--light); border: 2px solid var(--primary);">
            <div class="card-header text-white text-center" style="background: var(--primary);">
                <h2>Add a New Product</h2>
            </div>
            <div class="card-body">
                <form action="save_product.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label text-dark">Product Name:</label>
                        <input type="text" name="name" class="form-control" required placeholder="Enter product name" style="border-color: var(--primary);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Price:</label>
                        <input type="number" name="price" class="form-control" step="0.01" required placeholder="Enter price" style="border-color: var(--primary);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Status:</label>
                        <select name="status" class="form-select" required style="border-color: var(--primary);">
                            <option value="available">Available</option>
                            <option value="unavailable">Not Available</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Category:</label>
                        <select name="category_id" class="form-select" required style="border-color: var(--primary);">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <a href="addCategory.php" class="add-category-link text-primary">+ Add New Category</a>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Product Image:</label>
                        <input type="file" name="image" class="form-control" required style="border-color: var(--primary);">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary text-white" style="background: var(--secondary); border-color: var(--secondary);"><i class="fas fa-save"></i> Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>