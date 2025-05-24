<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailHelper{
    
    public static function sendMail(array $address, string $subject, string $body) : bool | string
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
            $mail->isSMTP();                                           
            $mail->Host       = MAIL_HOST;                    
            $mail->SMTPAuth   = MAIL_SMTP_AUTH;                                  
            $mail->Username   = MAIL_ADDRESS;                    
            $mail->Password   = MAIL_PASSWORD_KEY;                              
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
            $mail->Port       = MAIL_PORT;                        
            $mail->SMTPDebug = MAIL_SMTP_DEBUG;           

            $mail->setFrom(MAIL_ADDRESS, SYSTEM_NAME);

            foreach($address as $a){
                $mail->addAddress($a);
            }

            $mail->isHTML(true);                                 
            $mail->Subject = $subject;
            $mail->CharSet = 'UTF-8';

            ob_start();
            require_once __DIR__ . "/../../Views/templates/$body";
            $mail->Body = ob_get_clean();

            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

}