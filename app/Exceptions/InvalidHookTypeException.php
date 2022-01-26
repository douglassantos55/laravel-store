<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class InvalidHookTypeException extends Exception
{
    public function __construct(string $type, array $data)
    {
        $message = "Hook '{$type}' is not recognized";
        parent::__construct($message);

        Log::debug($message, $data);
    }
}
