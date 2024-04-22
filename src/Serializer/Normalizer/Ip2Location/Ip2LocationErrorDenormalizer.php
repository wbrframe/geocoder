<?php

namespace App\Serializer\Normalizer\Ip2Location;

use App\Model\Ip2Location\Ip2LocationError;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Ip2LocationErrorDenormalizer implements DenormalizerInterface
{
    /**
     * @param array{error: array{error_code: int, error_message: string}} $data
     * @param array<int, mixed>                                           $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): Ip2LocationError
    {
        return new Ip2LocationError($data['error']['error_code'], $data['error']['error_message']);
    }

    /**
     * @param array<int, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Ip2LocationError::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Ip2LocationError::class => true,
        ];
    }
}
