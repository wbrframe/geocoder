<?php

namespace App\Tests\Exception;

use App\Exception\Ip2LocationErrorException;
use App\Model\Ip2Location\Ip2LocationError;
use PHPUnit\Framework\TestCase;

class Ip2LocationErrorExceptionTest extends TestCase
{
    public function testConstruct(): void
    {
        $error = new Ip2LocationError(100, 'Incorrect IP address');
        $exception = new Ip2LocationErrorException($error);

        $this->assertSame('Incorrect IP address', $exception->getMessage());
        $this->assertSame(100, $exception->getCode());
        $this->assertSame(null, $exception->getPrevious());
    }
}
