<?php


namespace HS\PasswordLessBundle\Security\Authentication;


use HS\PasswordLessBundle\Entity\LoginHash;
use HS\PasswordLessBundle\Entity\Player as User;

class TokenGenerator
{
    private $temporaryTTL;
    private $ttl;

    public function __construct($ttl, $temporaryTTL)
    {
        $this->ttl = $ttl;
        $this->temporaryTTL = $temporaryTTL;
    }

    public function generateTemporaryToken(User $user)
    {
        $token = new LoginHash();
        $token->setUser($user)
            ->setTemporary(true)
            ->setTTL($this->getTTLDateTime($this->temporaryTTL))
            ->setHash($this->generateHash($user->getEmail()))
        ;

        return $token;
    }

    public function convertToken(LoginHash $token)
    {
        $token
            ->setTemporary(false)
            ->setTTL($this->getTTLDateTime($this->ttl))
            ->setHash($this->generateHash($token->getHash()))
        ;

        return $token;
    }

    private function generateHash($seed = null)
    {
        return md5(uniqid($seed, true));
    }

    private function getTTLDateTime($modifier)
    {
        $ttl = new \DateTime();
        $ttl->modify(sprintf('+%d minute', $modifier));

        return $ttl;
    }
}
