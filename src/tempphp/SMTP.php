<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class SMTP_Config
{
    public static function sendEmail($userEmail, $userName, $verificationLink)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug  = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mdiab0109666@gmail.com'; 
            $mail->Password   = 'lzddohjqzbfppgjw'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('no-reply@yourwebsite.com', 'Cafeteria');
            $mail->addAddress($userEmail, $userName);
            $mail->addReplyTo('no-reply@yourwebsite.com');

            $mail->isHTML(true);
            $mail->Subject = 'Confirm Your Account';
            $mail->Body    = "Hello <b>$userName</b>,<br> 
                              Click the following link to verify your account:<br>
                              <a href='$verificationLink'>$verificationLink</a>";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}
