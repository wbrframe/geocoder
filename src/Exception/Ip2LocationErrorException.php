<?php

namespace App\Exception;

use App\Model\Ip2Location\Ip2LocationError;

class Ip2LocationErrorException extends \Exception
{
    public function __construct(Ip2LocationError $error)
    {
        parent::__construct($error->getMessage(), $error->getCode());
    }
}
