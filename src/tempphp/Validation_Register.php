<?php
include_once("logic.php");
class ValidationRegister
{
    private static $pdo;

    public static function setDatabaseConnection($pdo)
    {
        self::$pdo = $pdo;
    }

    public static function UserName($username)
    {
        if (!isset($username) || empty(trim($username))) {
            throw new Exception('Username field is empty');
        }

        if (strpos($username, ' ') !== false) {
            throw new Exception('Username should not contain spaces');
        }

        if (strlen($username) < 3 || strlen($username) > 20) {
            throw new Exception('Username must be between 3 and 20 characters');
        }

        $stmt = self::$pdo->prepare("SELECT id FROM user WHERE Username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            throw new Exception('Username is already taken');
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

        // Check if email already exists in the database
        $stmt = self::$pdo->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->execute([$Email]);
        if ($stmt->fetch()) {
            throw new Exception('Email is already registered');
        }
    }

    public static function Password($password)
    {
        if (!isset($password) || empty(trim($password))) {
            throw new Exception('Password field is empty');
        }

        if (strlen($password) < 8) {
            throw new Exception('Password must be at least 8 characters long');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new Exception('Password must contain at least one uppercase letter');
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new Exception('Password must contain at least one lowercase letter');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new Exception('Password must contain at least one digit');
        }

        if (!preg_match('/[\W_]/', $password)) {
            throw new Exception('Password must contain at least one special character');
        }
    }

    public static function FirstName($firstName)
    {
        if (!isset($firstName) || empty($firstName)) {
            throw new Exception('Name field is empty');
        }

        if (!preg_match('/^[A-Za-z]+$/', $firstName)) {
            throw new Exception('Name should only contain letters');
        }
    }

    // public static function LastName($lastName)
    // {
    //     if (!isset($lastName) || empty(trim($lastName))) {
    //         throw new Exception('Last Name field is empty');
    //     }

    //     if (!preg_match('/^[A-Za-z]+$/', $lastName)) {
    //         throw new Exception('Last Name should only contain letters');
    //     }
    // }

    // public static function Phone($phone)
    // {
    //     if (!preg_match('/^\+?[0-9]{10,25}$/', $phone)) {
    //         throw new Exception('Invalid Phone number');
    //     }
    // }

    // public static function Gender($gender)
    // {
    //     if (!in_array($gender, ['Male', 'Female'])) {
    //         throw new Exception('Please select a valid gender');
    //     }
    // }

    public static function Role($role)
    {
        if (!in_array($role, ['admin', 'user'])) {
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

    public static function RoomID($room_id)
    {
        if (!isset($room_id) || empty($room_id)) {
            throw new Exception('Room ID is required.');
        }

        if (!is_numeric($room_id)) {
            throw new Exception('Invalid Room ID.');
        }

        $stmt = self::$pdo->prepare("SELECT id FROM room WHERE id = ?");
        $stmt->execute([$room_id]);

        if (!$stmt->fetch()) {
            throw new Exception('Room ID does not exist.');
        }
    }

}
