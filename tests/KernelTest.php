<?php

namespace App\Tests;

use App\DependencyInjection\CompilerPass\IpAddressInfoProviderCompilerPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class KernelTest extends TestCase
{
    public function testBuildAddsIpAddressInfoProviderCompilerPass(): void
    {
        $kernel = new TestableKernel('test', true);

        $containerBuilder = $this->createMock(ContainerBuilder::class);
        $containerBuilder
            ->expects(self::once())
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(IpAddressInfoProviderCompilerPass::class));

        $kernel->build($containerBuilder);
    }
}
