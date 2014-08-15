<?php

namespace HS\PasswordLessBundle\Security\Authentication;

use HS\PasswordLessBundle\Entity\LoginHash;

interface TokenProviderInterface
{
    public function persist(LoginHash $token);

    public function remove(LoginHash $token);

    public function removeByHash($hash);

    public function findByHash($hash);
}