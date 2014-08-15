<?php


namespace HS\PasswordLessBundle\Security\Events;


final class SecurityEvents
{
    /**
     * The FAILED_LOGIN event occurs after a password less login attempt fails.
     *
     * The event listener method receives a
     * Symfony\Component\HttpKernel\Event\GetResponseEvent instance.
     *
     * @var string
     */
    const LOGIN_FAILED = 'hs_passwordless_security_failed_login';
} 