<?php

namespace App\Controller\API\V10;

use App\Service\Cache\IpAddressInfoProvider;
use App\Service\Utils\IpAddressHelper;
use App\Traits\SerializerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

#[Route('/ip-address/{ipAddress}/info', name: 'api_v1.0_get_ip_address_info', requirements: ['ipAddress' => "[\d\.]{7,15}"], methods: ['GET'])]
final class GetIpAddressInfoController
{
    use SerializerTrait;

    public function __construct(private readonly IpAddressInfoProvider $ipAddressInfoProvider, private readonly IpAddressHelper $ipAddressHelper)
    {
    }

    public function __invoke(string $ipAddress): JsonResponse
    {
        $ipAddress = $this->ipAddressHelper->createFromRaw($ipAddress);
        $ipAddressInfo = $this->ipAddressInfoProvider->getInfo($ipAddress);

        $response = $this->serializer->serialize($ipAddressInfo, JsonEncoder::FORMAT);

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }
}
