<?php


namespace JUMA\Bundle\PingBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class MatchResultRepository extends EntityRepository
{
    public function getMatchListData()
    {
        $qb = $this->createQueryBuilder('m');
        $qb->join('m.localTeam', 'l');
        $qb->join('l.players', 'lp');
        $qb->join('m.versusTeam', 'v');
        $qb->join('v.players', 'vp');
        $qb->select('m.playDate');
        $qb->addSelect($qb->expr()->concat('lp.name', 'lp.id'));

        return $qb->getQuery()->getArrayResult();
    }
}
