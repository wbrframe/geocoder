<?php

namespace App\Tests\Serializer\Normalizer\Ip2Location;

use App\Model\Ip2Location\Ip2LocationError;
use App\Serializer\Normalizer\Ip2Location\Ip2LocationErrorDenormalizer;
use PHPUnit\Framework\TestCase;

class Ip2LocationErrorDenormalizerTest extends TestCase
{
    private Ip2LocationErrorDenormalizer $denormalizer;

    protected function setUp(): void
    {
        $this->denormalizer = new Ip2LocationErrorDenormalizer();
    }

    public function tearDown(): void
    {
        unset($this->denormalizer);
    }

    public function testDenormalize(): void
    {
        $data = [
            'error' => [
                'error_code' => 123,
                'error_message' => 'Test error message',
            ],
        ];

        $result = $this->denormalizer->denormalize($data, Ip2LocationError::class);

        $this->assertInstanceOf(Ip2LocationError::class, $result);
        $this->assertEquals(123, $result->getCode());
        $this->assertEquals('Test error message', $result->getMessage());
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertTrue($this->denormalizer->supportsDenormalization([], Ip2LocationError::class));
        $this->assertFalse($this->denormalizer->supportsDenormalization([], \stdClass::class));
    }
}
