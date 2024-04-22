<?php

namespace App\Tests\Model;

use App\Model\IpAddress;
use PHPUnit\Framework\TestCase;

class IpAddressTest extends TestCase
{
    public function testConstruct(): void
    {
        $ip = new IpAddress('192.168.0.1');
        $this->assertInstanceOf(IpAddress::class, $ip);
    }

    public function testGetValue(): void
    {
        $ipValue = '192.168.0.1';
        $ip = new IpAddress($ipValue);
        $this->assertEquals($ipValue, $ip->getValue());
    }

    public function testToString(): void
    {
        $ipValue = '192.168.0.1';
        $ip = new IpAddress($ipValue);
        $this->assertEquals($ipValue, (string) $ip);
    }
}
