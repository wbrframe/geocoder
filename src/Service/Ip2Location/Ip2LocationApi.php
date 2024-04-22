<?php

namespace App\Service\Ip2Location;

use App\Exception\Ip2LocationErrorException;
use App\Model\Ip2Location\Ip2LocationError;
use App\Model\IpAddress;
use App\Model\IpAddressInfo;
use App\Traits\SerializerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Ip2LocationApi
{
    use SerializerTrait;

    public function __construct(private readonly HttpClientInterface $ip2locationClient)
    {
    }

    public function getInfo(IpAddress $ipAddress): IpAddressInfo
    {
        $response = $this->ip2locationClient->request(Request::METHOD_GET, '/', [
            'query' => [
                'ip' => (string) $ipAddress,
            ],
        ]);

        $content = $response->getContent(false);

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            /** @var Ip2LocationError $error */
            $error = $this->serializer->deserialize($content, Ip2LocationError::class, JsonEncoder::FORMAT);

            throw new Ip2LocationErrorException($error);
        }

        /** @var IpAddressInfo $info */
        $info = $this->serializer->deserialize($content, IpAddressInfo::class, JsonEncoder::FORMAT);

        return $info;
    }
}
