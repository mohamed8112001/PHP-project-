<?php
include_once("mysqlconnection.php");
include_once("logic.php");
include_once("SMTP.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Forget_Password
{
    private $pdo;
    private $mail;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

        $this->mail = new PHPMailer(true);
        try {
            $this->mail->SMTPDebug  = 0; // تعطيل التصحيح في الإنتاج
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.gmail.com';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'mdiab0109666@gmail.com';
            $this->mail->Password   = 'lzddohjqzbfppgjw';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->Port       = 465;
            $this->mail->setFrom('mdiab0109666@gmail.com', 'Cafeteria');
        } catch (Exception $e) {
            die("❌ Mail setup error: " . $this->mail->ErrorInfo);
        }
    }

    public function generateResetToken($email)
    {
        try {
            $token = bin2hex(random_bytes(32));
            $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

            $stmt = $this->pdo->prepare("UPDATE user SET reset_token = ?, reset_expires_at = ? WHERE email = ?");
            echo "var_dump($stmt)";
            $stmt->execute([$token, $expires_at, $email]);

            if ($stmt->rowCount() > 0) {
                return $token;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Error generating reset token: " . $e->getMessage());
        }
    }


    public function getUserByToken($token)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE reset_token = ? AND reset_expires_at > NOW()");
            $stmt->execute([$token]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                echo "<script>alert('Invalid or expired token'); window.location.href='http://localhost/labs/tempphp/Login.html';</script>";
                exit();
            }

            return $user;
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

    public function updatePassword($email, $newPassword)
    {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE user SET password = ?, reset_token = NULL, reset_expires_at = NULL WHERE email = ?");
            $stmt->execute([$hashedPassword, $email]);
            var_dump($stmt->rowCount());
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
