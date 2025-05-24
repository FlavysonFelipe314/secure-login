<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Exceptions\AccountNotVerifyExeption;
use App\Helpers\AuthHelper;
use App\Helpers\MailHelper;
use App\Services\MailService;
use Exception;

class HomeController extends Controller{

    private $AuthHelper;
    private $checkToken;

    public function __construct()
    {
        $this->AuthHelper = new AuthHelper();
        $this->checkToken = $this->AuthHelper->checkToken();
        $this->AuthHelper->checkIsValidate($this->checkToken->getEmail());
        echo "<pre>";
        var_dump($this->checkToken);
        var_dump($_SESSION);

    }

    public function index()
    {   
        $data = [
            "user" => $this->checkToken,
        ];

        $this->loadTemplate("index", $data);
    }
}

