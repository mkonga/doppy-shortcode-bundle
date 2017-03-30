<?php

namespace Doppy\ShortcodeBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TagHandlerCompilerPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $containerBuilder)
    {
        $tagHandlerDefinition = $containerBuilder->findDefinition('doppy_shortcode.tag_handler');
        $taggedHandlers       = $this->findAndSortTaggedServices('doppy_shortcode.tag_handler', $containerBuilder);

        foreach ($taggedHandlers as $taggedHandlerReference) {
            $tagHandlerDefinition->addMethodCall('addHandler', array($taggedHandlerReference));
        }
    }
}
