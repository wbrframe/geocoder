<?php

namespace App\Tests\Controller\API\V10;

use App\Controller\API\V10\GetIpAddressInfoController;
use App\Model\IpAddress;
use App\Model\IpAddressInfo;
use App\Service\Cache\IpAddressInfoProvider;
use App\Service\Utils\IpAddressHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class GetIpAddressInfoControllerTest extends TestCase
{
    private MockObject $ipAddressInfoProvider;
    private MockObject $ipAddressHelper;
    private MockObject $serializer;
    private GetIpAddressInfoController $controller;

    protected function setUp(): void
    {
        $this->ipAddressInfoProvider = $this->createMock(IpAddressInfoProvider::class);
        $this->ipAddressHelper = $this->createMock(IpAddressHelper::class);
        $this->serializer = $this->createMock(SerializerInterface::class);

        $this->controller = new GetIpAddressInfoController(
            $this->ipAddressInfoProvider,
            $this->ipAddressHelper
        );
        $this->controller->setSerializer($this->serializer);
    }

    public function tearDown(): void
    {
        unset(
            $this->ipAddressInfoProvider,
            $this->ipAddressHelper,
            $this->controller,
            $this->serializer
        );
    }

    public function testAction(): void
    {
        $ipAddress = new IpAddress('127.0.0.1');
        $ipAddressInfo = $this->createMock(IpAddressInfo::class);

        $this->ipAddressHelper
            ->expects(self::once())
            ->method('createFromRaw')
            ->with($ipAddress)
            ->willReturn($ipAddress);

        $this->ipAddressInfoProvider
            ->expects(self::once())
            ->method('getInfo')
            ->with($ipAddress)
            ->willReturn($ipAddressInfo);

        $response = '{"info":"data"}';

        $this->serializer
            ->expects($this->once())
            ->method('serialize')
            ->with($ipAddressInfo, JsonEncoder::FORMAT)
            ->willReturn($response);

        $response = ($this->controller)($ipAddress);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('{"info":"data"}', $response->getContent());
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}
