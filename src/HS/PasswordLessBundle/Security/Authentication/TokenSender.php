<?php


namespace HS\PasswordLessBundle\Security\Authentication;

use Swift_Mailer;
use HS\PasswordLessBundle\Entity\LoginHash;
use Symfony\Component\Templating\EngineInterface;

class TokenSender
{
    private $mailer;
    private $renderer;
    private $emailConfig;

    public function __construct(Swift_Mailer $mailer, EngineInterface $renderer, $emailConfig)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
        $this->emailConfig = $emailConfig;
    }

    public function sendToken(LoginHash $loginHash)
    {
        $user = $loginHash->getUser();
        $message = new \Swift_Message();
        $message
            ->setSender($this->emailConfig['sender'], $this->emailConfig['sender_name'])
            ->setSubject($this->emailConfig['subject'])
            ->setTo($user->getEmail(), $user->getName())
            ->setBody(
                $this->renderer->render(
                    $this->emailConfig['template'],
                    array('hash' => $loginHash->getHash())),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
