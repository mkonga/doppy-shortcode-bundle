<?php

namespace Doppy\ShortcodeBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;

class ConfiguredProcessorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // loop through all configured processors
        foreach ($container->getParameter('doppy_shortcode.processors') as $alias => $processor) {
            // create definition for configured processor
            $definition = new Definition(
                'Doppy\Shortcode\Processor\Processor',
                array(
                    $processor,
                    $container->getDefinition('doppy_shortcode.parser'),
                    $container->getDefinition('doppy_shortcode.tag_handler')
                )
            );

            // tag it so it gets picked up
            $definition->addTag('doppy_shortcode.processor', ['priority' => -10000, 'alias' => $alias]);

            // add it to container
            $container->addDefinitions(
                array('doppy_shortcode.processor.' . $alias => $definition)
            );
        }
    }
}