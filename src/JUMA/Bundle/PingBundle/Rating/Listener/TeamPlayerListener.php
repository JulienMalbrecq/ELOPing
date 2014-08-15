<?php


namespace JUMA\Bundle\PingBundle\Rating\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use JUMA\Bundle\PingBundle\Entity\RatedInterface;
use JUMA\Bundle\PingBundle\Entity\Team;

class TeamPlayerListener
{
    private $baseRating;

    public function __construct($baseRating = 1400)
    {
        $this->baseRating = $baseRating;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var RatedInterface $entity */
        $entity = $args->getEntity();
        if (!$this->supportEntity($entity)) {
            return;
        }

        $team = new Team();
        $team->addPlayer($entity);
        $args->getEntityManager()->persist($team);
    }

    public function supportEntity($entity)
    {
        return $entity instanceof RatedInterface;
    }

} 