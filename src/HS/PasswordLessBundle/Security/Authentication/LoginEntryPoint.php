<?php

namespace HS\PasswordLessBundle\Security\Authentication;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class LoginEntryPoint implements AuthenticationEntryPointInterface
{
    private $router;
    private $loginPath;

    public function __construct(RouterInterface $router, $loginPath = '/')
    {
        $this->router = $router;
        $this->loginPath = $loginPath;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate($this->loginPath));
    }
}