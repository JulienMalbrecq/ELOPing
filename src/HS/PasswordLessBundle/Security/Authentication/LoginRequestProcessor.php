<?php


namespace HS\PasswordLessBundle\Security\Authentication;

use HS\PasswordLessBundle\Entity\LoginHash;
use HS\PasswordLessBundle\Entity\Player as User;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginRequestProcessor
{
    private $tokenProvider;
    private $generator;
    private $sender;
    private $cookieName;

    public function __construct(TokenProviderInterface $tokenProvider, TokenGenerator $generator, TokenSender $sender, $cookieName)
    {
        $this->tokenProvider = $tokenProvider;
        $this->generator = $generator;
        $this->sender = $sender;
        $this->cookieName = $cookieName;
    }

    /**
     * Generate a temporary login token and send it to the user
     *
     * @param User $user
     */
    public function processUserRequest(User $user)
    {
        $token = $this->generator->generateTemporaryToken($user);
        $this->tokenProvider->persist($token);

        $this->sender->sendToken($token);
    }

    /**
     * Convert a temporary token into a regular one and prepare a redirect response
     *
     * @param LoginHash $token
     *
     * @return RedirectResponse
     */
    public function confirmUserToken(LoginHash $token)
    {
        $this->generator->convertToken($token);

        // prepare the response;
        $response = new RedirectResponse('/');
        $response->headers->setCookie(
            new Cookie($this->cookieName,
                $token->getHash(),
                $token->getTTL()->getTimestamp()
            )
        );

        return $response;
    }
} 