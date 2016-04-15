<?php

namespace Doppy\ShortcodeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('doppy_shortcode');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('processors')
                    ->useAttributeAsKey('alias')
                    ->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->integerNode('max_depth')
                                ->defaultValue(10)
                                ->min(1)
                                ->max(100)
                            ->end()
                            ->arrayNode('handlers')
                                ->prototype('scalar')->end()
                            ->end()
                            ->scalarNode('fallback_handler')
                                ->defaultValue('fallback.shortcode')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
