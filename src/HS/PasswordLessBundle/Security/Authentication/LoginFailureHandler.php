<?php


namespace HS\PasswordLessBundle\Security\Authentication;


use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class LoginFailureHandler implements AccessDeniedHandlerInterface
{
    private $router;
    private $loginRoute;

    public function __construct(RouterInterface $router, $loginRoute)
    {
        $this->router = $router;
        $this->loginRoute = $loginRoute;
    }

    public function handle(Request $request, AccessDeniedException $exception)
    {
        $url = $this->router->generate($this->loginRoute);
        var_dump($url);
        return new Response($url);
    }
} 