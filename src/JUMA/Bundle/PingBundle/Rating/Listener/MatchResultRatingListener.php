<?php


namespace JUMA\Bundle\PingBundle\Rating\Listener;

use JUMA\Bundle\PingBundle\Entity\MatchResult;
use JUMA\Bundle\PingBundle\Rating\Event\MatchResultEvent;
use JUMA\Bundle\PingBundle\Rating\RatingComputer;

class MatchResultRatingListener
{
    private $computer;

    public function __construct(RatingComputer $computer)
    {
        $this->computer = $computer;
    }

    public function prePersist(MatchResultEvent $event)
    {
        $match = $event->getMatchResult();
        $this->computer->applyMatchResultRating($match);
    }
} 