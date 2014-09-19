<?php


namespace HS\PasswordLessBundle\Security\Authentication\Provider;

use HS\PasswordLessBundle\Security\Authentication\Token\PasswordlessToken;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PasswordlessProvider implements AuthenticationProviderInterface
{
    private $userProvider;

    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function authenticate(TokenInterface $token)
    {
        $user = $token->getUser();

        if (!($user instanceof UserInterface)) {
            $user = $this->userProvider->loadUserByUsername($user);
        }

        if ($user && $user->isActive()) {
            $authenticatedToken = new PasswordlessToken($user->getRoles());
            $authenticatedToken->setUser($user);

            return $authenticatedToken;
        }

        throw new AuthenticationException('The Passwordless authentication failed.');
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof PasswordlessToken;
    }

}
