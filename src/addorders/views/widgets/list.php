<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>
<body>
    <div class="product-grid-container" id="productGrid">
        <?php 
        include 'controllers/productController.php';

        $controller = new ProductController();
        $orderController = new OrderController();
        $products=$controller->getAllProduct();

        foreach ($products  as $product){

            $res = $orderController->isLimitedOrpopular($product);
            echo '<div class="product-grid-item">';

            if ($res === "popular") {
                echo '<span class="product-badge product-popular">Popular</span>';
            } else if ($res === "limited") {
                echo '<span class="product-badge product-limited">Limited</span>';
            }
        
            echo '
                <img src="' . $product->imagePath . '" alt="' . $product->name . '" class="product-img">
                <h6>' . $product->name . '</h6>
                <div class="product-price">' . $product->price . ' LE</div>
            </div>';
        }
        ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
</body>
</html>