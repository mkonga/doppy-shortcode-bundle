<?php

namespace Doppy\ShortcodeBundle\DependencyInjection\CompilerPass;

use Doppy\ShortcodeBundle\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProcessorContainerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $containerBuilder)
    {
        $providerBuilderDefinition = $containerBuilder->findDefinition('doppy_shortcode.processor');
        $taggedProcessors          = $this->getTaggedProcessors($containerBuilder);

        foreach ($taggedProcessors as $priority => $taggedProcessor) {
            // check attribute
            if (!isset($taggedProcessor['attributes']['alias'])) {
                throw $this->createInvalidArgumentException($taggedProcessor['service_id']);
            }

            // set processor lazy
            $processorDefinition = $containerBuilder->getDefinition($taggedProcessor['service_id']);
            $processorDefinition->setLazy(true);

            $providerBuilderDefinition->addMethodCall(
                'add',
                array($taggedProcessor['service_id'], $taggedProcessor['attributes']['alias'])
            );
        }
    }

    /**
     * @param ContainerBuilder $containerBuilder
     *
     * @return array
     */
    protected function getTaggedProcessors(ContainerBuilder $containerBuilder)
    {
        $services = array();
        foreach ($containerBuilder->findTaggedServiceIds('doppy_shortcode.processor') as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                // determine priority
                $attributes['priority']              = isset($attributes['priority']) ? $attributes['priority'] : 0;
                $services[$attributes['priority']][] = array('service_id' => $serviceId, 'attributes' => $attributes);
            }
        }
        krsort($services);
        $returnServices = [];
        foreach ($services as $nested) {
            foreach ($nested as $service) {
                $returnServices[] = $service;
            }
        }
        return $returnServices;
    }

    /**
     * Creates an exception
     *
     * @param string $serviceId
     *
     * @return InvalidConfigurationException
     */
    private function createInvalidArgumentException($serviceId)
    {
        return new InvalidConfigurationException(
            sprintf('Required attribute "alias" is missing on tag "doppy_shortcode.processor" for service "%s".', $serviceId)
        );
    }
}
