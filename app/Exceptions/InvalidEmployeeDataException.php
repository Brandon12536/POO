<?php

namespace App\Exceptions;

use Exception;

class InvalidEmployeeDataException extends Exception
{
    public function __construct(string $message = "Datos de empleado inválidos", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
