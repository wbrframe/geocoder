<?php

namespace App\Tests\Service\Ip2Location;

use App\Exception\Ip2LocationErrorException;
use App\Model\Ip2Location\Ip2LocationError;
use App\Model\IpAddress;
use App\Model\IpAddressInfo;
use App\Service\Ip2Location\Ip2LocationApi;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Ip2LocationApiTest extends TestCase
{
    private MockObject $ip2locationClient;
    private MockObject $serializer;
    private Ip2LocationApi $ip2LocationApi;

    protected function setUp(): void
    {
        $this->ip2locationClient = $this->createMock(HttpClientInterface::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->ip2LocationApi = new Ip2LocationApi($this->ip2locationClient);
        $this->ip2LocationApi->setSerializer($this->serializer);
    }

    public function tearDown(): void
    {
        unset($this->ip2locationClient, $this->serializer, $this->ip2LocationApi);
    }

    public function testGetInfoSuccess(): void
    {
        $ipAddress = new IpAddress('192.168.0.1');
        $fakeApiResponse = '{"some": "json"}';

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock
            ->expects(self::once())
            ->method('getContent')
            ->with(false)
            ->willReturn($fakeApiResponse);

        $responseMock
            ->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(Response::HTTP_OK);

        $this->ip2locationClient
            ->expects(self::once())
            ->method('request')
            ->with(Request::METHOD_GET, '/', [
                'query' => [
                    'ip' => (string) $ipAddress,
                ],
            ])
            ->willReturn($responseMock);

        $this->serializer
            ->expects(self::once())
            ->method('deserialize')
            ->with($fakeApiResponse, IpAddressInfo::class, JsonEncoder::FORMAT)
            ->willReturn(new IpAddressInfo());

        $result = $this->ip2LocationApi->getInfo($ipAddress);

        $this->assertInstanceOf(IpAddressInfo::class, $result);
    }

    public function testGetInfoError(): void
    {
        $ipAddress = new IpAddress('192.168.0.1');
        $fakeApiResponse = '{"some": "json"}';

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock
            ->expects(self::once())
            ->method('getContent')
            ->with(false)
            ->willReturn($fakeApiResponse);

        $responseMock
            ->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(Response::HTTP_BAD_REQUEST);

        $this->ip2locationClient
            ->expects(self::once())
            ->method('request')
            ->with(Request::METHOD_GET, '/', [
                'query' => [
                    'ip' => (string) $ipAddress,
                ],
            ])
            ->willReturn($responseMock);

        $this->serializer
            ->expects(self::once())
            ->method('deserialize')
            ->with($fakeApiResponse, Ip2LocationError::class, JsonEncoder::FORMAT)
            ->willReturn(new Ip2LocationError(100, 'Some error message'));

        $this->expectException(Ip2LocationErrorException::class);
        $this->expectExceptionCode(100);
        $this->expectExceptionMessage('Some error message');

        $this->ip2LocationApi->getInfo($ipAddress);
    }
}
