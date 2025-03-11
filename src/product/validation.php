<?php
class Validator {

    public static function sanitize($data) {
        return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
    }

    public static function validateProductName($name) {
        if (empty($name) || strlen($name) > 50) {
            return false;
        }
        return true;
    }

    public static function validatePrice($price) {
        return is_numeric($price) && $price >= 0;
    }

    public static function validateStatus($status) {
        $allowed_statuses = ['available', 'unavailable'];
        return in_array($status, $allowed_statuses);
    }

    public static function validateCategoryId($category_id) {
        return filter_var($category_id, FILTER_VALIDATE_INT) !== false;
    }
}
?>
