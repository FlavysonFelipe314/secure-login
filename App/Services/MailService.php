<?php

namespace App\Services;

use App\Exceptions\AccountNotVerifyExeption;
use App\Exceptions\InvalidVerifyCode;
use App\Models\User;
use App\Repository\UserRepository;
use Exception;

class MailService{
    private $UserRepository;

    public function __construct()
    {
        $this->UserRepository = new UserRepository;
    }

    public static function generateVerifyLink() : bool 
    {
        self::expiredVerifyLink();

        $token = bin2hex(random_bytes(32));
        $recoveryLink = BASE_DIR."/verify-account?validate_email_code=$token";

        $_SESSION["verify-token"][$token] = time();
        $_SESSION["recovery-link"] = $recoveryLink;

        return true;
    }

    public static function validateVerifyLink($token, $email) : bool
    {
        self::expiredVerifyLink();

        if(!(array_key_exists($token, $_SESSION["verify-token"]))){
            throw new InvalidVerifyCode();
        }

        $User = new User;
        $User->setEmail($email);
        $User->setIsVerified(1);

        try{
            UserService::verifyAccount($User);
            
            unset($_SESSION["verify-token"]);
            unset($_SESSION["recovery-link"]);
        } catch(Exception $err){
            return $err->getMessage();
        }

        return true;
    }

    public static function checkVerifyLink($email) : bool
    {
        $UserService = new UserService;

        $_SESSION["user-email"] = $email;
        
        $user = $UserService->findBy("email", $email);
        
        if($user->getIsVerified() === 0){
            throw new AccountNotVerifyExeption();
        }
        
        unset($_SESSION["user-email"]);
        return true;
    }

    private static function expiredVerifyLink() : void
    {
        if(!isset($_SESSION["verify-token"])){
            echo "seu token não é válido";
        }

        foreach($_SESSION["verify-token"] as $token => $time){
            if(time() > $time + 100){
                echo "seu token expirou";
                unset($_SESSION["verify-token"]);
                unset($_SESSION["recovery-link"]);
            }
        }

    }

}