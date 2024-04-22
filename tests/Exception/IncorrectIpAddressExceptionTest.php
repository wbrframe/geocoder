<?php

namespace App\Tests\Exception;

use App\Exception\IncorrectIpAddressException;
use PHPUnit\Framework\TestCase;

class IncorrectIpAddressExceptionTest extends TestCase
{
    public function testConstruct(): void
    {
        $exception = new IncorrectIpAddressException('192.160.0.1');

        $this->assertSame('Incorrect IP address 192.160.0.1', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame(null, $exception->getPrevious());
    }
}
