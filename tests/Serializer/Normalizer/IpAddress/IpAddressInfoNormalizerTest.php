<?php

namespace App\Tests\Serializer\Normalizer\IpAddress;

use App\Model\IpAddress;
use App\Model\IpAddressInfo;
use App\Serializer\Normalizer\IpAddress\IpAddressInfoNormalizer;
use PHPUnit\Framework\TestCase;

class IpAddressInfoNormalizerTest extends TestCase
{
    private IpAddressInfoNormalizer $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new IpAddressInfoNormalizer();
    }

    public function tearDown(): void
    {
        unset($this->normalizer);
    }

    public function testNormalize(): void
    {
        $ipAddress = new IpAddress('127.0.0.1');

        $ipAddressInfo = new IpAddressInfo();
        $ipAddressInfo->setIp($ipAddress);
        $ipAddressInfo->setCountryCode('US');
        $ipAddressInfo->setCountryName('United States');

        $result = $this->normalizer->normalize($ipAddressInfo);

        $this->assertEquals([
            'ip' => '127.0.0.1',
            'countryCode' => 'US',
            'countryName' => 'United States',
        ], $result);
    }

    public function testSupportsNormalization(): void
    {
        $this->assertTrue($this->normalizer->supportsNormalization(new IpAddressInfo()));
        $this->assertFalse($this->normalizer->supportsNormalization(new \stdClass()));
    }
}
