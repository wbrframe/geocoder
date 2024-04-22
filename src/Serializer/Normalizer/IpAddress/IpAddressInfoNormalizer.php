<?php

namespace App\Serializer\Normalizer\IpAddress;

use App\Model\IpAddressInfo;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class IpAddressInfoNormalizer implements NormalizerInterface
{
    /**
     * @param IpAddressInfo     $object
     * @param array<int, mixed> $context
     *
     * @return array<string, string>
     */
    public function normalize($object, ?string $format = null, array $context = []): array
    {
        $data['ip'] = (string) $object->getIp();
        $data['countryCode'] = $object->getCountryCode();
        $data['countryName'] = $object->getCountryName();

        return $data;
    }

    /**
     * @param array<int, mixed> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof IpAddressInfo;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            IpAddressInfo::class => true,
        ];
    }
}
