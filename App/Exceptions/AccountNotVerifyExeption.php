<?php

namespace App\Exceptions;

use Exception;

class AccountNotVerifyExeption extends Exception{
    public function __construct(string $message = "A conta não foi verificada", int $code = 403)
    {
        parent::__construct($message, $code);        
    }
}