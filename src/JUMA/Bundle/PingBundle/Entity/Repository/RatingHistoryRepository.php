<?php


namespace JUMA\Bundle\PingBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use HS\PasswordLessBundle\Entity\Player;

class RatingHistoryRepository extends EntityRepository
{
    public function getPlayerHistory(Player $player)
    {
        $qb = $this->createQueryBuilder('h');
        $qb->select('h.creationDate, h.rating');
        $qb->where('h.player = :player')->setParameter('player', $player);
        $qb->orderBy('h.creationDate', 'ASC');

        $rating = $qb->getQuery()->useQueryCache(true)->getArrayResult();

        // add current player rating
        array_push(
            $rating,
            array(
                'creationDate' => new \DateTime(),
                'rating' => $player->getRating()
            )
        );

        return $rating;
    }
} 