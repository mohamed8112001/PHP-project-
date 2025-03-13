<?php
session_start(); // Start session for potential future use
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('business_logic.php');
include_once('../template/nav.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="templates/styleTemplate.css">
</head>
<body style="background-color: var(--light);">
    <div class="container mt-5">
        <div class="card shadow-lg" style="background: var(--light); border: 2px solid var(--primary);">
            <div class="card-header text-white text-center" style="background: var(--primary);">
                <h2>Add New Category</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <p><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="saveData.php" method="post" id="registrationForm">
                    <div class="mb-3">
                        <label class="form-label text-dark">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required placeholder="Enter your name" value="<?= htmlspecialchars($name ?? '') ?>" style="border-color: var(--primary);">
                    </div>
                    <div class="text-center">
                        <button type="submit" name="send" class="btn btn-secondary text-white" style="background: var(--secondary); border-color: var(--secondary);">
                            <i class="fas fa-user-plus"></i> Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>