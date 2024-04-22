<?php

namespace App\Tests\Model\Ip2Location;

use App\Model\Ip2Location\Ip2LocationError;
use PHPUnit\Framework\TestCase;

class Ip2LocationErrorTest extends TestCase
{
    public function testConstruct(): void
    {
        $error = new Ip2LocationError(100, 'Error message');
        $this->assertSame(100, $error->getCode());
        $this->assertSame('Error message', $error->getMessage());
    }
}
