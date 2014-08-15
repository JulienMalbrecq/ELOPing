<?php

namespace JUMA\Bundle\PingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HS\PasswordLessBundle\Entity\Player;

/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="JUMA\Bundle\PingBundle\Entity\Repository\TeamRepository")
 */
class Team
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="HS\PasswordLessBundle\Entity\Player", fetch="EAGER")
     * @ORM\OrderBy({"rating" = "ASC"})
     */
    private $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $players
     */
    public function setPlayers($players)
    {
        $this->players = $players;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param \JUMA\Bundle\PingBundle\Entity\RatedInterface $player
     *
     * @return Team
     */
    public function addPlayer(RatedInterface $player)
    {
        $this->players->add($player);

        return $this;
    }

    /**
     * @param Player $player
     *
     * @return $this
     */
    public function removePlayer(Player $player)
    {
        $this->players->removeElement($player);

        return $this;
    }

    /**
     * @param Player $player
     *
     * @return bool
     */
    public function hasPlayer(Player $player)
    {
        return $this->players->contains($player);
    }

    /**
     * @return integer
     */
    public function getAverageRating()
    {
        $totalRating = 0;
        $players = $this->getPlayers()->toArray();
        array_walk(
            $players,
            function (RatedInterface $player) use (&$totalRating) {
                $totalRating += $player->getRating();
            }
        );

        return round($totalRating / $this->getPlayers()->count());
    }

    /**
     * @param string $separator
     *
     * @return string
     */
    public function getPlayersName($separator = ' - ')
    {
        $players = $this->getPlayers()->toArray();
        return join($separator, $players);
    }

    public function __toString()
    {
        return $this->getPlayersName();
    }
}
