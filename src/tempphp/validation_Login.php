<?php
include_once("logic.php");

class ValidationLogin
{
    private $functions;

    public function __construct($pdo)
    {
        $this->functions = new Query_database($pdo);
    }

    public function validateUser($input, $password)
    {
        $user = $this->functions->getUserByEmailOrUsername($input);
        var_dump($user);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function login($input, $password)
    {
        $user = $this->validateUser($input, $password);
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role'];

            // Redirect based on user role
            $redirectPage = ($user['Role'] === 'admin') ? 'admin_dashboard.php' : 'user_dashboard.php';
            header("Location: $redirectPage");
            exit();
        } else {
            echo "<script>alert('Invalid Username, Email, or Password!'); window.location.href='index.php';</script>";
        }
    }
}
