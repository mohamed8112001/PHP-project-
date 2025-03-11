<?php
class ValidationRegister
{
    public static function UserName($username)
    {
        if (!isset($username) || empty(trim($username))) {
            throw new Exception('Username field is empty');
        }
    }

    public static function Email($Email)
    {
        if (!isset($Email) || empty(trim($Email))) {
            throw new Exception('Email field is empty');
        }

        $Email = trim(strtolower($Email));
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid Email Format: ' . htmlspecialchars($Email));
        }
    }

    public static function Password($password)
    {
        if (!isset($password) || empty(trim($password))) {
            throw new Exception('Password field is empty');
        }
    }

    public static function FirstName($firstName)
    {
        if (!isset($firstName) || empty(trim($firstName))) {
            throw new Exception('First Name field is empty');
        }
    }

    public static function LastName($lastName)
    {
        if (!isset($lastName) || empty(trim($lastName))) {
            throw new Exception('Last Name field is empty');
        }
    }

    public static function Phone($phone)
    {
        if (!preg_match('/^[0-9]{10,25}$/', $phone)) {
            throw new Exception('Invalid Phone number');
        }
    }

    public static function Gender($gender)
    {
        if (!in_array($gender, ['Male', 'Female'])) {
            throw new Exception('Please select a valid gender');
        }
    }

    public static function Role($role)
    {
        if (!in_array($role, ['Admin', 'User'])) {
            throw new Exception('Please select a valid role');
        }
    }

    public static function ProfileImage($file)
    {
        if (isset($file) && $file["error"] == 0) {
            $allowed_types = ["jpg", "jpeg", "png"];
            $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

            if (!in_array($imageFileType, $allowed_types)) {
                throw new Exception('Only JPG, JPEG, and PNG files are allowed.');
            }

            if ($file["size"] > 10 * 1024 * 1024) {
                throw new Exception('Image size must be less than 10MB.');
            }
        }
    }
}
