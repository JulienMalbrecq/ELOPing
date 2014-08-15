<?php

namespace HS\PasswordLessBundle\Registration;

use HS\PasswordLessBundle\Entity\Player as User;
use HS\PasswordLessBundle\Registration\Events\Event\RegistrationEvent;
use HS\PasswordLessBundle\Registration\Events\RegistrationEvents;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RegistrationHandler
{
    private $om;
    private $dispatcher;

    public function __construct(ObjectManager $om, EventDispatcherInterface $dispatcher)
    {
        $this->om = $om;
        $this->dispatcher = $dispatcher;
    }

    public function registerUser(User $user)
    {
        try {
            $user->setActive(true);
            $this->om->persist($user);
            $this->om->flush($user);

            $this->dispatcher->dispatch(
                RegistrationEvents::REGISTRATION_SUCCESS,
                new RegistrationEvent($user)
            );

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}