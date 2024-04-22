<?php

namespace App\Tests\DependencyInjection\CompilerPass;

use App\DependencyInjection\CompilerPass\IpAddressInfoProviderCompilerPass;
use App\Service\IpAddress\Ip2LocationInfoProvider;
use App\Service\IpAddress\IpAddressInfoProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class IpAddressInfoProviderCompilerPassTest extends TestCase
{
    private IpAddressInfoProviderCompilerPass $compilerPass;

    public function setUp(): void
    {
        $this->compilerPass = new IpAddressInfoProviderCompilerPass();
    }

    public function tearDown(): void
    {
        unset($this->compilerPass);
    }

    public function testProcess(): void
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container
            ->expects($this->once())
            ->method('setAlias')
            ->with(IpAddressInfoProviderInterface::class, Ip2LocationInfoProvider::class);

        $this->compilerPass->process($container);
    }
}
