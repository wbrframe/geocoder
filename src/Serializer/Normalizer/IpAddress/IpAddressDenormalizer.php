<?php

namespace App\Serializer\Normalizer\IpAddress;

use App\Model\IpAddress;
use App\Service\Utils\IpAddressHelper;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class IpAddressDenormalizer implements DenormalizerInterface
{
    private IpAddressHelper $ipAddressHelper;

    public function __construct(IpAddressHelper $ipAddressHelper)
    {
        $this->ipAddressHelper = $ipAddressHelper;
    }

    /**
     * @param string            $data
     * @param array<int, mixed> $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): IpAddress
    {
        return $this->ipAddressHelper->createFromRaw($data);
    }

    /**
     * @param array<int, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return IpAddress::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            IpAddress::class => true,
        ];
    }
}
