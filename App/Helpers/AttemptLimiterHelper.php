<?php

namespace App\Helpers;

class AttemptLimiterHelper{

    public static function validateTry($email){
        self::checkExpireAttempt();       
        $attempts = self::checkAttempts();

        if($attempts >= 5){
            if(!isset($_SESSION["blocked_mail"])){
                $_SESSION["blocked_mail"] = $email;
                $_SESSION["block_time"] = time() + 30;
                $_SESSION["ip_user_trying"] = $_SERVER["REMOTE_ADDR"];
                $_SESSION["browser_user_trying"] = $_SERVER["HTTP_USER_AGENT"];
                MailHelper::sendMail([$email], "Alerta de Acesso", "alert-access-account.php");
            }
            
            if($_SESSION["blocked_mail"] == $email){
                header("Location: ".BASE_DIR."/block-account");
                exit;
            }

        }
    }

    public static function addAttempts($email){
        self::checkExpireAttempt();       

        if(isset($_SESSION["attempts"]) && self::checkSameEmail($email)){
            $_SESSION["attempts"] += 1;
            return true;
        }

        $_SESSION["attempt_mail"] = $email;
        $_SESSION["attempts"] = 1;
    }

    private static function checkAttempts(){
        if(!isset($_SESSION["attempts"])){
            $_SESSION["attempts"] = 0;
        }

        return $_SESSION["attempts"];
    }

    private static function checkSameEmail($email){
        $_SESSION["attempt_mail"] = !isset($_SESSION["attempt_mail"]) ? $_SESSION["attempt_mail"] = $email : $_SESSION["attempt_mail"]; 

        if($_SESSION["attempt_mail"] !== $email){
            return false;
            exit;
        }

        return true;
    }

    private static function checkExpireAttempt(){
        if(isset($_SESSION["block_time"]) && time() > $_SESSION["block_time"]){
            unset($_SESSION["block_time"]);
            unset($_SESSION["blocked_mail"]);
            unset($_SESSION["attempt_mail"]);
            $_SESSION["attempts"] = 0;
            return true;
        }
    }

}