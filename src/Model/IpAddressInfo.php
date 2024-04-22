<?php

namespace App\Model;

class IpAddressInfo
{
    private IpAddress $ip;
    private string $countryCode;
    private string $countryName;

    public function getIp(): IpAddress
    {
        return $this->ip;
    }

    public function setIp(IpAddress $ip): void
    {
        $this->ip = $ip;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): void
    {
        $this->countryName = $countryName;
    }
}
