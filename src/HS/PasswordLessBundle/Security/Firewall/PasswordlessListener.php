<?php

namespace HS\PasswordLessBundle\Security\Firewall;

use HS\PasswordLessBundle\Security\Events\SecurityEvents;
use HS\PasswordLessBundle\Security\Authentication\TokenProviderInterface;
use HS\PasswordLessBundle\Security\Authentication\Token\PasswordlessToken;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

class PasswordlessListener implements ListenerInterface
{
    protected $securityContext;
    protected $authenticationManager;
    protected $tokenProvider;
    private $cookieName;
    private $dispatcher;

    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, TokenProviderInterface $tokenProvider, EventDispatcherInterface $dispatcher, $cookieName = 'PLHash')
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->tokenProvider = $tokenProvider;
        $this->cookieName = $cookieName;
        $this->dispatcher = $dispatcher;
    }

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        try {
            if (!$request->cookies->has($this->cookieName)) {
                throw new \Exception('No cookie found'); // bypass cookie verification
            }

            $hash = $request->cookies->get($this->cookieName);
            $token = new PasswordlessToken();
            $token->setUser($hash);

            $authToken = $this->authenticationManager->authenticate($token);
            $this->securityContext->setToken($authToken);

            return;
        } catch (AuthenticationException $failed) {
            $token = $this->securityContext->getToken();
            if ($token instanceof PasswordlessToken && $this->providerKey === $token->getProviderKey()) {
                $this->securityContext->setToken(null);
            }

            $this->handleFailure($event);

        } catch (\Exception $e) {
            // do nothing
        }

    }

    protected function handleFailure(GetResponseEvent $event)
    {
        $response = new Response();
        $event->setResponse($response);

        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        $this->dispatcher->dispatch(SecurityEvents::LOGIN_FAILED, $event);

        $response->headers->clearCookie($this->cookieName, '/');
    }
} 