<?php

namespace App\Exceptions;

use Exception;

class InvalidVerifyCode extends Exception{
    public function __construct(string $message = "O código de verificação é inválido!", int $code = 403)
    {
        parent::__construct($message, $code);
    }
}