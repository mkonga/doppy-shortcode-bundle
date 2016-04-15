<?php

namespace Doppy\ShortcodeBundle\DependencyInjection\CompilerPass;

use Doppy\UtilBundle\Helper\CompilerPass\TaggedServicesTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class ProcessorContainerCompilerPass implements CompilerPassInterface
{
    use TaggedServicesTrait;

    public function process(ContainerBuilder $container)
    {
        $this->processTaggedServices($container, 'doppy_shortcode.processor', 'add', true, true);
    }
}