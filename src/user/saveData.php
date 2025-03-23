<?php
include_once('blogic.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$success_message = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name'] ?? '');
    var_dump($_POST);
   
    if (empty($name)) {
        $errors[] = 'Name is required.';
    } elseif (strlen($name) < 3) {
        $errors[] = 'Name must be at least 3 characters long.';
    }

    
    if (!empty($errors)) {
    } else {
        try {
            $blogic = new Category();
            $blogic->insertCategory($name);
            header("Location:addCategory.php");
            exit; 
           
        } catch (Exception $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
