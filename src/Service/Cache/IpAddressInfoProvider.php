<?php

namespace App\Service\Cache;

use App\Model\IpAddress;
use App\Model\IpAddressInfo;
use App\Service\IpAddress\IpAddressInfoProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class IpAddressInfoProvider
{
    public function __construct(private readonly CacheInterface $ipAddressInfoCache, private readonly IpAddressInfoProviderInterface $ipAddressInfoProvider)
    {
    }

    public function getInfo(IpAddress $ipAddress): IpAddressInfo
    {
        $ipAddressInfoProvider = $this->ipAddressInfoProvider;

        /** @var IpAddressInfo $value */
        $value = $this->ipAddressInfoCache->get((string) $ipAddress, function (ItemInterface $item) use ($ipAddressInfoProvider, $ipAddress) {
            return $ipAddressInfoProvider->getInfo($ipAddress);
        });

        return $value;
    }
}
