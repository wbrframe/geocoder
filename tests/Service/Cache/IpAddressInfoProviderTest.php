<?php

namespace App\Tests\Service\Cache;

use App\Model\IpAddress;
use App\Model\IpAddressInfo;
use App\Service\Cache\IpAddressInfoProvider;
use App\Service\IpAddress\IpAddressInfoProviderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class IpAddressInfoProviderTest extends TestCase
{
    private MockObject $ipAddressInfoCache;
    private MockObject $ipAddressInfoProvider;
    private IpAddressInfoProvider $service;

    public function setUp(): void
    {
        $this->ipAddressInfoCache = $this->createMock(CacheInterface::class);
        $this->ipAddressInfoProvider = $this->createMock(IpAddressInfoProviderInterface::class);
        $this->service = new IpAddressInfoProvider($this->ipAddressInfoCache, $this->ipAddressInfoProvider);
    }

    public function tearDown(): void
    {
        unset($this->ipAddressInfoCache, $this->ipAddressInfoProvider, $this->service);
    }

    public function testGetInfoWithCacheHit(): void
    {
        $ipAddress = new IpAddress('127.0.0.1');
        $expectedInfo = new IpAddressInfo();

        $this->ipAddressInfoCache
            ->expects(self::once())
            ->method('get')
            ->with((string) $ipAddress)
            ->willReturn($expectedInfo);

        $this->ipAddressInfoProvider
            ->expects(self::never())
            ->method('getInfo');

        $result = $this->service->getInfo($ipAddress);

        $this->assertSame($expectedInfo, $result);
    }

    public function testGetInfoWithCacheMiss(): void
    {
        $ipAddress = new IpAddress('127.0.0.1');
        $expectedInfo = new IpAddressInfo();

        $this->ipAddressInfoCache
            ->expects(self::once())
            ->method('get')
            ->with((string) $ipAddress)
            ->will($this->returnCallback(function ($ipAddress, $callback) {
                return $callback($this->createMock(ItemInterface::class));
            }));

        $this->ipAddressInfoProvider
            ->expects(self::once())
            ->method('getInfo')
            ->with($ipAddress)
            ->willReturn($expectedInfo);

        $result = $this->service->getInfo($ipAddress);

        $this->assertSame($expectedInfo, $result);
    }
}
