<?php

namespace HS\PasswordLessBundle\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class PasswordlessFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.passwordless.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('hs_passwordless.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider))
        ;

        $listenerId = 'security.authentication.listener.passwordless.'.$id;
        $container
            ->setDefinition($listenerId, new DefinitionDecorator('hs_passwordless.security.authentication.listener'))
            ->replaceArgument(4, $config['cookie_name']);

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'passwordless';
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('cookie_name')->defaultValue('passwordless_hash')->end()
                ->scalarNode('login_path')->end()
            ->end();
    }
} 