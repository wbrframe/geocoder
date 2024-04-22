<?php

namespace App\DependencyInjection\CompilerPass;

use App\Service\IpAddress\Ip2LocationInfoProvider;
use App\Service\IpAddress\IpAddressInfoProviderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class IpAddressInfoProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->setAlias(IpAddressInfoProviderInterface::class, Ip2LocationInfoProvider::class);
    }
}
