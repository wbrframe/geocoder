<?php

namespace App\Service\IpAddress;

use App\Model\IpAddress;
use App\Model\IpAddressInfo;

interface IpAddressInfoProviderInterface
{
    public function getInfo(IpAddress $ipAddress): IpAddressInfo;
}
