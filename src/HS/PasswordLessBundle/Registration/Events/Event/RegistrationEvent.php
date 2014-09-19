<?php


namespace HS\PasswordLessBundle\Registration\Events\Event;


use HS\PasswordLessBundle\Entity\Player;
use Symfony\Component\EventDispatcher\Event;

class RegistrationEvent extends Event
{

    protected $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function getPlayer()
    {
        return $this->player;
    }
}
