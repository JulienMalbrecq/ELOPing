<?php


namespace HS\PasswordLessBundle\Registration\Events\Listener;


use HS\PasswordLessBundle\Registration\Events\Event\RegistrationEvent;

class RegistrationSuccessListener
{
    public function onRegistrationSuccess(RegistrationEvent $event)
    {
        // @todo Generate a temporary e-mail and send it to the user
    }
} 