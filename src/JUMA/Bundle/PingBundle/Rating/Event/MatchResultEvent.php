<?php


namespace JUMA\Bundle\PingBundle\Rating\Event;


use JUMA\Bundle\PingBundle\Entity\MatchResult;
use Symfony\Component\EventDispatcher\Event;

class MatchResultEvent extends Event
{
    private $match;

    public function __construct(MatchResult $match)
    {
        $this->match = $match;
    }

    /**
     * @return MatchResult
     */
    public function getMatchResult()
    {
        return $this->match;
    }
} 