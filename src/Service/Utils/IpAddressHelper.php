<?php

namespace App\Service\Utils;

use App\Exception\IncorrectIpAddressException;
use App\Model\IpAddress;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IpAddressHelper
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function createFromRaw(string $value): IpAddress
    {
        $errors = $this->validator->validate($value, new Assert\Ip());

        if ($errors->count() > 0) {
            throw new IncorrectIpAddressException($value);
        }

        return new IpAddress($value);
    }
}
