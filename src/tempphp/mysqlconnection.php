<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Database
{
    private static $pdo = null;

    private function __construct() {}

    public static function getConnection()
    {
        if (self::$pdo === null) {
            try {
                $server     = 'localhost';
                $database   = 'mydatabase';
                $username   = 'root';
                $password   = 'Mohamed_Diab123';

                self::$pdo = new PDO("mysql:host=$server;dbname=$database", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

$pdo = Database::getConnection();
