<?php


namespace JUMA\Bundle\PingBundle\Entity\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class TeamRepository extends EntityRepository
{
    public function findByPlayers(ArrayCollection $players)
    {

        $qb = $this->createQueryBuilder('t');
        $qb->leftJoin('t.players', 'p');
        $qb->groupBy('t.id');
        $qb->having('count(t) = :count')
            ->setParameter('count', $players->count());

        $qb->setMaxResults('1');

        foreach ($players->toArray() as $key => $player) {
            $parameter = sprintf('player%d', $key);
            $qb->andWhere(":$parameter MEMBER OF t.players")->setParameter($parameter, $player);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
} 