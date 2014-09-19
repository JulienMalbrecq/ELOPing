<?php


namespace JUMA\Bundle\PingBundle\Rating;


use JUMA\Bundle\PingBundle\Entity\MatchResult;
use JUMA\Bundle\PingBundle\Entity\Team;
use JUMA\Bundle\PingBundle\Rating\Event\MatchResultEvent;
use JUMA\Bundle\PingBundle\Rating\Event\RatingEvents;
use JUMA\lib\EloRating;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RatingComputer
{
    private $computer;
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->computer = new EloRating();
    }

    public function applyMatchResultRating(MatchResult $match)
    {
        $winnerTeam = $match->getWinnerTeam();
        $loserTeam = $match->getLoserTeam();

        // get the average team ratings before applying the new ones
        $winnerTeamRating = $winnerTeam->getAverageRating();
        $loserTeamRating = $loserTeam->getAverageRating();

        $event = new MatchResultEvent($match);
        $this->dispatcher->dispatch(RatingEvents::BEFORE_RATING, $event);

        $this->applyTeamRating(EloRating::STATUS_WIN, $winnerTeam, $loserTeamRating);
        $this->applyTeamRating(EloRating::STATUS_LOST, $loserTeam, $winnerTeamRating);

        $this->dispatcher->dispatch(RatingEvents::AFTER_RATING, $event);
    }

    public function applyTeamRating($resultOfMatch, Team $team, $versusRating)
    {
        foreach ($team->getPlayers() as $player) {
            $elo = $this->computer->compute($resultOfMatch, $player->getRating(), $versusRating);
            $player->setRating($elo);
        }
    }
}
