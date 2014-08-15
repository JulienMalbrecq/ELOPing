<?php

namespace JUMA\Bundle\PingBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('juma_ping');

        $rootNode
            ->children()
                ->arrayNode('rating')
                    ->children()
                        ->integerNode('entry_rating')->defaultValue('1400')->end()
                    ->end()
        ;

        return $treeBuilder;
    }
}
