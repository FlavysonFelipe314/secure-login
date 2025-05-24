<?php

namespace App\Exceptions;

use Exception;

class InvalidCsrfTokenException extends Exception{
    public function __construct(string $message = "Csrf token é inválido!", int $code = 403)
    {
        parent::__construct($message, $code);
    }
}