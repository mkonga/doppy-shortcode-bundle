<?php

namespace Doppy\ShortcodeBundle\DependencyInjection\CompilerPass;

use Doppy\UtilBundle\Helper\CompilerPass\BaseTagServiceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ProcessorContainerCompilerPass extends BaseTagServiceCompilerPass
{
    protected function handleTag(
        ContainerBuilder $containerBuilder,
        Definition $serviceDefinition,
        Reference $taggedServiceReference,
        $attributes
    )
    {
        $serviceDefinition->addMethodCall(
            'add',
            array(
                $attributes['service_id'],
                $attributes['alias']
            )
        );
    }

    protected function getService(ContainerBuilder $containerBuilder)
    {
        return $containerBuilder->getDefinition('doppy_shortcode.processor');
    }

    protected function getTaggedServices(ContainerBuilder $containerBuilder)
    {
        return $containerBuilder->findTaggedServiceIds('doppy_shortcode.processor');
    }

    protected function adjustTaggedService(Definition $definition)
    {
        $definition->setLazy(true);
    }
}