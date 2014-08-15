<?php


namespace JUMA\Bundle\PingBundle\Form\DataTransformer;


use Doctrine\Common\Persistence\ObjectManager;
use JUMA\Bundle\PingBundle\Entity\Team;
use Symfony\Component\Form\DataTransformerInterface;

class TeamToArrayCollectionTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (Team) to an ArrayCollection.
     *
     * @param  Team|null $team
     * @return ArrayCollection|null
     */
    public function transform($team)
    {
        if (null === $team) {
            return null;
        }

        return $team->getPlayers();
    }

    /**
     * Transforms an ArrayCollection to an object (Team).
     *
     * @param  ArrayCollection $players
     *
     * @return Team
     */
    public function reverseTransform($players)
    {
        if (!$players) {
            return null;
        }

        $team = $this->om
            ->getRepository('JUMAPingBundle:Team')
            ->findByPlayers($players)
        ;

        if (null === $team) {
            $team = new Team();
            $team->setPlayers($players);
        }

        return $team;
    }

} 