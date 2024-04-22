<?php

namespace App\Tests;

use App\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TestableKernel extends Kernel
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }
}
