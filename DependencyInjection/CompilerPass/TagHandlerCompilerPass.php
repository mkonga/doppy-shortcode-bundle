<?php

namespace Doppy\ShortcodeBundle\DependencyInjection\CompilerPass;

use Doppy\UtilBundle\Helper\CompilerPass\BaseTagServiceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class TagHandlerCompilerPass extends BaseTagServiceCompilerPass
{
    protected function handleTag(
        ContainerBuilder $containerBuilder,
        Definition $serviceDefinition,
        Reference $taggedServiceReference,
        $attributes
    )
    {
        $serviceDefinition->addMethodCall(
            'addHandler',
            array(
                $taggedServiceReference
            )
        );
    }

    protected function getService(ContainerBuilder $containerBuilder)
    {
        return $containerBuilder->getDefinition('doppy_shortcode.tag_handler');
    }

    protected function getTaggedServices(ContainerBuilder $containerBuilder)
    {
        return $containerBuilder->findTaggedServiceIds('doppy_shortcode.tag_handler');
    }
}