<?php

namespace App\Tests\Service\Utils;

use App\Exception\IncorrectIpAddressException;
use App\Model\IpAddress;
use App\Service\Utils\IpAddressHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IpAddressHelperTest extends TestCase
{
    private MockObject $validator;
    private IpAddressHelper $ipAddressHelper;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->ipAddressHelper = new IpAddressHelper($this->validator);
    }

    public function tearDown(): void
    {
        unset($this->validator, $this->ipAddressHelper);
    }

    public function testCreateFromRawValid(): void
    {
        $validIp = '192.168.0.1';

        $constraintViolationList = $this->createMock(ConstraintViolationListInterface::class);
        $constraintViolationList->method('count')->willReturn(0);

        $this->validator
            ->expects(self::once())
            ->method('validate')
            ->with($validIp, self::isInstanceOf(Assert\Ip::class))
            ->willReturn($constraintViolationList);

        $ipAddress = $this->ipAddressHelper->createFromRaw($validIp);

        $this->assertInstanceOf(IpAddress::class, $ipAddress);
        $this->assertEquals($validIp, $ipAddress->getValue());
    }

    public function testCreateFromRawInvalid(): void
    {
        $invalidIp = 'invalid-ip';

        $constraintViolationList = $this->createMock(ConstraintViolationListInterface::class);
        $constraintViolationList->method('count')->willReturn(1);

        $this->validator
            ->expects(self::once())
            ->method('validate')
            ->with($invalidIp, self::isInstanceOf(Assert\Ip::class))
            ->willReturn($constraintViolationList);

        $this->expectException(IncorrectIpAddressException::class);
        $this->expectExceptionMessage($invalidIp);

        $this->ipAddressHelper->createFromRaw($invalidIp);
    }
}
