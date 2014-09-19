<?php


namespace HS\PasswordLessBundle\Security\Events\Listener;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class LoginHashUpdatedResponseListener
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $om;
    private $cookieName;

    public function __construct(ObjectManager $om, $cookieName)
    {
        $this->om = $om;
        $this->cookieName = $cookieName;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($token = $request->attributes->get('login_hash_updated', null)) {
            $response = $event->getResponse();
            $response->headers->setCookie(
                new Cookie($this->cookieName,
                    $token->getHash(),
                    $token->getTTL()->getTimestamp()
                )
            );

            $this->om->flush($token);
        }
    }
}
