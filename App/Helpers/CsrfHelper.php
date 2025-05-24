<?php

namespace App\Helpers;

use App\Exceptions\InvalidCsrfTokenException;

class CsrfHelper{
 
    public static function generateToken() : string
    {
        self::cleanExpiratedToken();

        $token = bin2hex(random_bytes(64));
        $_SESSION["CSRF_TOKEN"][$token] = time();

        return $token;
    }

    public static function validateToken($token): bool
    {
        self::cleanExpiratedToken();

        if(!isset($_SESSION["CSRF_TOKEN"]) || !(array_key_exists($token, $_SESSION["CSRF_TOKEN"]))){
            throw new InvalidCsrfTokenException();
        }

        unset($_SESSION["CSRF_TOKEN"][$token]);

        return true;
    }

    private static function cleanExpiratedToken() : void
    {
        if(isset($_SESSION["CSRF_TOKEN"])){
            foreach($_SESSION["CSRF_TOKEN"] as $token => $exp_time){
                if(time() > ($exp_time + 900)){
                    unset($_SESSION["CSRF_TOKEN"][$token]);
                }
            }
        }
    }
    
}