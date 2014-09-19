<?php


namespace HS\PasswordLessBundle\Security\Authentication;

use HS\PasswordLessBundle\Entity\LoginHash;
use HS\PasswordLessBundle\Entity\Player as User;

class LoginRequestProcessor
{
    private $tokenProvider;
    private $generator;
    private $sender;

    public function __construct(TokenProviderInterface $tokenProvider, TokenGenerator $generator, TokenSender $sender)
    {
        $this->tokenProvider = $tokenProvider;
        $this->generator = $generator;
        $this->sender = $sender;
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
     * Convert a temporary token into a regular one
     *
     * @param LoginHash $token
     *
     * @return boolean
     */
    public function confirmUserToken(LoginHash $token)
    {
        $beforeState = $token->isTemporary();
        $this->generator->convertToken($token);
        return $token->isTemporary() !== $beforeState;
    }
}
