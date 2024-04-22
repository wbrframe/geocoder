<?php

namespace App\Service\IpAddress;

use App\Model\IpAddress;
use App\Model\IpAddressInfo;
use App\Service\Ip2Location\Ip2LocationApi;

class Ip2LocationInfoProvider implements IpAddressInfoProviderInterface
{
    public function __construct(private readonly Ip2LocationApi $ip2LocationApi)
    {
    }

    public function getInfo(IpAddress $ipAddress): IpAddressInfo
    {
        return $this->ip2LocationApi->getInfo($ipAddress);
    }
}
