<?php

namespace App\Tests\Model;

use App\Model\IpAddress;
use App\Model\IpAddressInfo;
use PHPUnit\Framework\TestCase;

class IpAddressInfoTest extends TestCase
{
    private IpAddressInfo $ipAddressInfo;

    protected function setUp(): void
    {
        $this->ipAddressInfo = new IpAddressInfo();
    }

    public function tearDown(): void
    {
        unset($this->ipAddressInfo);
    }

    public function testSetAndGetIp(): void
    {
        $ip = new IpAddress('127.0.0.1');
        $this->ipAddressInfo->setIp($ip);
        $this->assertSame($ip, $this->ipAddressInfo->getIp());
    }

    public function testSetAndGetCountryCode(): void
    {
        $countryCode = 'US';
        $this->ipAddressInfo->setCountryCode($countryCode);
        $this->assertEquals($countryCode, $this->ipAddressInfo->getCountryCode());
    }

    public function testSetAndGetCountryName(): void
    {
        $countryName = 'United States';
        $this->ipAddressInfo->setCountryName($countryName);
        $this->assertEquals($countryName, $this->ipAddressInfo->getCountryName());
    }
}
