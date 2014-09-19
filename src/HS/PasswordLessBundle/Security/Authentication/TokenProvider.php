<?php

namespace HS\PasswordLessBundle\Security\Authentication;

use Doctrine\Common\Persistence\ObjectManager;
use HS\PasswordLessBundle\Entity\LoginHash;

class TokenProvider implements TokenProviderInterface
{
    private $repository;
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->repository = $om->getRepository('HSPasswordLessBundle:LoginHash');
    }

    public function findByHash($hash)
    {
        return $this->repository
            ->findOneBy(
                array('hash' => $hash)
            );
    }

    public function removeByHash($hash)
    {
        $token = $this->findByHash($hash);
        if (!$token) {
            return;
        }

        $this->remove($token);
    }

    public function persist(LoginHash $token)
    {
        $this->om->persist($token);
    }

    public function remove(LoginHash $token)
    {
        $this->om->remove($token);
    }
}
