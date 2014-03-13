<?php

namespace Malwarebytes\TestDataBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('malwarebytes_test_data');

        $rootNode
            ->children()
                ->arrayNode('objects')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('entity')->end()
                        ->enumNode('type')
                            ->values(array('csv','xml'))
                        ->end()
                        ->scalarNode('file')->end()
                ->end()
            ->end();

        return $treeBuilder;

        return $treeBuilder;
    }
}
