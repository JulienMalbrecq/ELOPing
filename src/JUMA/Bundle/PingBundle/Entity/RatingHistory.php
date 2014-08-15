<?php

namespace JUMA\Bundle\PingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HS\PasswordLessBundle\Entity\Player;

/**
 * RatingHistory
 *
 * @ORM\Table(name="rating_history")
 * @ORM\Entity(repositoryClass="JUMA\Bundle\PingBundle\Entity\Repository\RatingHistoryRepository")
 */
class RatingHistory
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
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="HS\PasswordLessBundle\Entity\Player")
     */
    private $player;

    /**
     * @var integer
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function initFromPlayer(Player $player)
    {
        $this
            ->setCreationDate(new \DateTime())
            ->setPlayer($player)
            ->setRating($player->getRating())
        ;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return RatingHistory
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \HS\PasswordLessBundle\Entity\Player $player
     *
     * @return RatingHistory
     */
    public function setPlayer(Player $player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * @return \HS\PasswordLessBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param int $rating
     *
     * @return RatingHistory
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }
}
