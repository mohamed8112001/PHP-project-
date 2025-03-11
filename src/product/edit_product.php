<?php
session_start();
include 'config.php';
include 'business_logic.php';
include 'validation.php';

$database = new Database($pdo);
$db       = new BusinessLogic($database);

if (!isset($_GET['id'])) {
    die("طلب غير صالح");
}
$id = $_GET['id'];
$product = $db->get_product_by_id($id);
if (!$product) {
    die("المنتج غير موجود");
}
$categories = $db->get_all_categories();
include 'templates/header.php';
?>
<div class="container">
    <h2>تعديل المنتج</h2>
    <form action="update_product.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <input type="text" name="name" required placeholder="اسم المنتج" value="<?= $product['name'] ?>">
        <input type="number" name="price" step="0.01" required placeholder="السعر" value="<?= $product['price'] ?>">
        <select name="status" required>
            <option value="available" <?= $product['status'] == 'available' ? 'selected' : '' ?>>متوفر</option>
            <option value="unavailable" <?= $product['status'] == 'unavailable' ? 'selected' : '' ?>>غير متوفر</option>
        </select>
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>الصورة الحالية:</label>
        <?php if (!empty($product['image_path']) && file_exists($product['image_path'])): ?>
            <img src="<?= $product['image_path'] ?>" class="product-img" alt="Product Image">
        <?php else: ?>
            <span>لا توجد صورة</span>
        <?php endif; ?>
        <input type="file" name="product_image">
        <button type="submit">تحديث المنتج</button>
    </form>
</div>
<?php include 'templates/footer.php'; ?>
