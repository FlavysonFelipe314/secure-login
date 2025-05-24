<?php

namespace App\Helpers;

use App\Exceptions\AccountNotVerifyExeption;
use App\Models\User;
use App\Repository\UserRepository;
use App\Services\MailService;
use Exception;

class AuthHelper{

    private $UserRepository;

    public function __construct()
    {
        $this->UserRepository = new UserRepository;    
    }
    
    public function checkToken(){
        if(!empty($_SESSION["token"])){
            $user = $this->UserRepository->findBy("token", $_SESSION["token"]);

            if(empty($user) || !isset($user)){
                header("Location:".BASE_DIR."/login");
                exit;
            }

            return $user;
            exit;
        }
        
        header("Location:".BASE_DIR."/login");
        exit;
    }

    public function checkIsValidate($email){
        try{
            MailService::checkVerifyLink($email);
        } catch(AccountNotVerifyExeption $err){
            MailService::generateVerifyLink($email);
            MailHelper::sendMail([$email], "Link de verificação", "verify-account.php");

            header("Location:". BASE_DIR . "/verify-account");
        } catch(Exception $err){
            return $err->getMessage();
        }
    }

    public function logout(){
        session_destroy();
        session_unset();
        session_regenerate_id(true);
    }

}