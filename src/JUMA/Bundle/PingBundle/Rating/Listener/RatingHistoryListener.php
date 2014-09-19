<?php


namespace JUMA\Bundle\PingBundle\Rating\Listener;


use Doctrine\Common\Persistence\ObjectManager;
use JUMA\Bundle\PingBundle\Entity\RatingHistory;
use JUMA\Bundle\PingBundle\Entity\Team;
use JUMA\Bundle\PingBundle\Rating\Event\MatchResultEvent;

class RatingHistoryListener
{
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function onBeforeRating(MatchResultEvent $event)
    {
        $match = $event->getMatchResult();

        $this->logTeamRating($match->getLocalTeam());
        $this->logTeamRating($match->getVersusTeam());
    }

    private function logTeamRating(Team $team)
    {
        foreach($team->getPlayers() as $player) {
            $ratingHistory = new RatingHistory();
            $ratingHistory->initFromPlayer($player);
            $this->om->persist($ratingHistory);
        }
    }
}
