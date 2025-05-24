<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InvalidCsrfTokenException;
use App\Exceptions\InvalidVerifyCode;
use App\Exceptions\MethodNotAllowedException;
use App\Helpers\AttemptLimiterHelper;
use App\Helpers\AuthHelper;
use App\Helpers\CsrfHelper;
use App\Helpers\MailHelper;
use App\Services\MailService;
use App\Services\UserService;
use Exception;

class UserController extends Controller{

    private $AuthHelper;    
    private $UserService;    

    public function __construct()
    {
        $this->AuthHelper = new AuthHelper();
        $this->UserService = new UserService();
    }

    public function login()
    {       
        $token = CsrfHelper::generateToken();
        
        $data = [
            "token" => $token
        ];

        $this->loadView("login", $data);
    }

    public function loginAction()
    {
        $this->__validateMethod("POST");

        $email = htmlspecialchars(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL), ENT_QUOTES, "UTF-8");
        $password = htmlspecialchars(filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS), ENT_QUOTES, "UTF-8");
        $token = htmlspecialchars(filter_input(INPUT_POST, "csrf_token", FILTER_SANITIZE_FULL_SPECIAL_CHARS), ENT_QUOTES, "UTF-8");

        try{
            CsrfHelper::validateToken($token);
            AttemptLimiterHelper::validateTry($email);

            $this->UserService->authenticate($email, $password);
            header("Location: ".BASE_DIR."/");
        } catch(InvalidCredentialsException $err){
            AttemptLimiterHelper::addAttempts($email);
            header("Location: ".BASE_DIR."/");    
        } catch(InvalidCsrfTokenException $err){
            header("Location: ".BASE_DIR."/login"); 
        } catch(Exception $err){
            echo "Algo deu errado: ".$err->getMessage();
        } 
    }

    public function cadastro()
    {
        $token = CsrfHelper::generateToken();

        $data = [
            "token" => $token
        ];

        $this->loadView("cadastro", $data); 
    }

    public function cadastroAction()
    {
        $this->__validateMethod("POST");

        $name = htmlspecialchars(filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS), ENT_QUOTES, "UTF-8");
        $email = htmlspecialchars(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL), ENT_QUOTES, "UTF-8");
        $password = htmlspecialchars(filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS), ENT_QUOTES, "UTF-8");
        $token = htmlspecialchars(filter_input(INPUT_POST, "csrf_token", FILTER_SANITIZE_FULL_SPECIAL_CHARS), ENT_QUOTES, "UTF-8");

        if(!empty($name) && !empty($email) && !empty($password)){
            try{
                CsrfHelper::validateToken($token);

                $_SESSION["user-email"] = $email;

                $this->UserService->create($name, $email, $password);
                
                MailService::generateVerifyLink($email);
                MailHelper::sendMail([$email], "Link de verificação", "verify-account.php");

                header("Location:". BASE_DIR . "/verify-account");
                exit;
            }catch(InvalidCsrfTokenException $err){
                return $err->getMessage();
            } catch(Exception $err){
                return $err->getMessage();
            }
        }

        header("Location:".BASE_DIR."/login");
        exit;
    }

    public function verifyAccount()
    {    
        echo "<pre>";
        var_dump($_SESSION);
        if(isset($_GET["validate_email_code"])){
            $code = htmlspecialchars(filter_input(INPUT_GET, "validate_email_code", FILTER_SANITIZE_FULL_SPECIAL_CHARS), ENT_QUOTES, "UTF-8");
            
            $email = $_SESSION["user-email"];
            try{
                MailService::validateVerifyLink($code, $email);
                unset($_SESSION["user-email"]);
                
                header("Location:".BASE_DIR."/");
            } catch(InvalidVerifyCode $err){
                echo $err->getMessage();
            } catch(Exception $err){
                echo $err->getMessage();
            }
        }

        $this->loadView("verify-account");
    }

    public function blockAccount(){
        $this->loadView("block-account");
    }

    public function logout()
    {
        try{
            $this->AuthHelper->logout();
            header("Location: ".BASE_DIR . "/");
        } catch(Exception $err){
            return $err->getMessage();
        }
    }

    private function __validateMethod($method)
    {
        if($_SERVER["REQUEST_METHOD"] !== $method){
            throw new MethodNotAllowedException();
        }
    }

}
