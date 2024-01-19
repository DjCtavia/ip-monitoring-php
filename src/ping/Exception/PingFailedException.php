<?php

namespace ping\Exception;

use Exception;

class PingFailedException extends Exception
{
    public function __construct(string $host, string $message = 'Ping failed on host: ', int $code = 0, Exception $previous = null)
    {
        parent::__construct($message . $host, $code, $previous);
    }
}