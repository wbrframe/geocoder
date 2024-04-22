<?php

namespace App\Tests\Serializer\Normalizer\IpAddress;

use App\Model\IpAddress;
use App\Serializer\Normalizer\IpAddress\IpAddressDenormalizer;
use App\Service\Utils\IpAddressHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IpAddressDenormalizerTest extends TestCase
{
    private MockObject $ipAddressHelper;
    private IpAddressDenormalizer $denormalizer;

    protected function setUp(): void
    {
        $this->ipAddressHelper = $this->createMock(IpAddressHelper::class);
        $this->denormalizer = new IpAddressDenormalizer($this->ipAddressHelper);
    }

    public function tearDown(): void
    {
        unset($this->ipAddressHelper, $this->denormalizer);
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertTrue($this->denormalizer->supportsDenormalization('', IpAddress::class));
        $this->assertFalse($this->denormalizer->supportsDenormalization('', 'FooClass'));
    }

    public function testDenormalize(): void
    {
        $ipAddress = '192.168.0.1';
        $expectedIpAddress = new IpAddress($ipAddress);

        $this->ipAddressHelper->expects($this->once())
            ->method('createFromRaw')
            ->with($ipAddress)
            ->willReturn($expectedIpAddress);

        $ipAddress = $this->denormalizer->denormalize($ipAddress, IpAddress::class);

        $this->assertSame($expectedIpAddress, $ipAddress);
    }
}
