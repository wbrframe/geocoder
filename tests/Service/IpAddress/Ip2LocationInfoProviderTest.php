<?php

namespace App\Tests\Service\IpAddress;

use App\Model\IpAddress;
use App\Service\Ip2Location\Ip2LocationApi;
use App\Service\IpAddress\Ip2LocationInfoProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class Ip2LocationInfoProviderTest extends TestCase
{
    private MockObject $ip2LocationApi;
    private Ip2LocationInfoProvider $ip2LocationInfoProvider;

    protected function setUp(): void
    {
        $this->ip2LocationApi = $this->createMock(Ip2LocationApi::class);
        $this->ip2LocationInfoProvider = new Ip2LocationInfoProvider($this->ip2LocationApi);
    }

    public function tearDown(): void
    {
        unset($this->ip2LocationApi, $this->ip2LocationInfoProvider);
    }

    public function testGetInfo(): void
    {
        $ipAddress = new IpAddress('192.168.0.1');

        $this->ip2LocationApi
            ->expects(self::once())
            ->method('getInfo')
            ->with($ipAddress);

        $this->ip2LocationInfoProvider->getInfo($ipAddress);
    }
}
