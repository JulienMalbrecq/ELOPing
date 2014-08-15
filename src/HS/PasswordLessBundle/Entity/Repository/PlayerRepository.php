<?php


namespace HS\PasswordLessBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class PlayerRepository extends EntityRepository implements UserProviderInterface
{
    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        $this->find($user->getId());
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return Boolean
     */
    public function supportsClass($class)
    {
        return $class === 'HS\PasswordLessBundle\Entity\Player';
    }

    public function loadUserByUsername($username)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->join('HSPasswordLessBundle:LoginHash', 'l')
            ->where('l.hash = :hash')->setParameter('hash', $username)
            ->andWhere('l.ttl > :now')->setParameter('now', new \DateTime())
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getOrderedPlayerRatings()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p.id, p.name, p.rating');
        $qb->orderBy('p.rating', 'DESC');

        return $qb->getQuery()->useQueryCache(true)->getArrayResult();
    }
} 