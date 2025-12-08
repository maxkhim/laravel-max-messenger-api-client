<?php

namespace Maxkhim\MaxMessengerApiClient\Exceptions;

use Exception;

class MaxBotException extends Exception
{
    protected $context = [];

    public function __construct($message = "", $code = 0, Exception $previous = null, $context = [])
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }
}