<?php

namespace App\Exception;

class IncorrectIpAddressException extends \Exception
{
    public function __construct(string $ip)
    {
        parent::__construct(sprintf('Incorrect IP address %s', $ip));
    }
}
