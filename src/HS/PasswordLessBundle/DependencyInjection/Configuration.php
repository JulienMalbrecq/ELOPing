<?php

namespace HS\PasswordLessBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('hs_password_less');

        $rootNode
            ->children()
                ->arrayNode('security')
                    ->children()
                        ->integerNode('token_ttl')->defaultValue(365)->end()
                        ->integerNode('token_temporary_ttl')->defaultValue(10)->end()
                    ->end()
                ->end()

                ->arrayNode('login')
                    ->children()
                        ->arrayNode('email')
                            ->children()
                                ->scalarNode('sender')->isRequired()->end()
                                ->scalarNode('subject')->isRequired()->end()
                                ->scalarNode('template')->defaultValue('HSPasswordLessBundle:Email:login_request.html.twig')->end()
                                ->scalarNode('sender_name')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
