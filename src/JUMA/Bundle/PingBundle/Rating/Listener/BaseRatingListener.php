<?php


namespace JUMA\Bundle\PingBundle\Rating\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use JUMA\Bundle\PingBundle\Entity\RatedInterface;

class BaseRatingListener
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

        $entity->setRating($this->baseRating);

    }

    public function supportEntity($entity)
    {
        return $entity instanceof RatedInterface;
    }

} 