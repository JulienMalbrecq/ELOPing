<?php

namespace HS\PasswordLessBundle;

use HS\PasswordLessBundle\Security\Factory\PasswordlessFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HSPasswordLessBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new PasswordlessFactory());
    }
}
