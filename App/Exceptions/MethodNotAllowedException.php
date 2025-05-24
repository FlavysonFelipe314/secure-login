<?php

namespace App\Exceptions;

use Exception;

class MethodNotAllowedException extends Exception{
    public function __construct(string $message = "Metodo de requisição não é permitido", int $code = 405)
    {
        parent::__construct($message, $code);        
    }
}