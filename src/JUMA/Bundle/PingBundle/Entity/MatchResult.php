<?php

namespace JUMA\Bundle\PingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="match_result")
 * @ORM\Entity(repositoryClass="JUMA\Bundle\PingBundle\Entity\Repository\MatchResultRepository")
 */
class MatchResult
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
     * @ORM\Column(name="play_date", type="datetime")
     */
    private $playDate;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="JUMA\Bundle\PingBundle\Entity\Team", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="local_team_id", referencedColumnName="id", nullable=false)
     */
    private $localTeam;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JUMA\Bundle\PingBundle\Entity\Team", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="versus_team_id", referencedColumnName="id", nullable=false)
     */
    private $versusTeam;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JUMA\Bundle\PingBundle\Entity\Team", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="winner_team_id", referencedColumnName="id")
     */
    private $winnerTeam;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="JUMA\Bundle\PingBundle\Entity\MatchSet", mappedBy="match")
     */
    private $sets;

    public function __construct()
    {
        $this->sets = new ArrayCollection();
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
     * @param \DateTime $playDate
     *
     * @return MatchResult
     */
    public function setPlayDate(\DateTime $playDate)
    {
        $this->playDate = $playDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPlayDate()
    {
        return $this->playDate;
    }

    /**
     * @param \JUMA\Bundle\PingBundle\Entity\Team
     *
     * @return MatchResult
     */
    public function setVersusTeam(Team $versusTeam)
    {
        $this->versusTeam = $versusTeam;

        return $this;
    }

    /**
     * @return Team
     */
    public function getVersusTeam()
    {
        return $this->versusTeam;
    }

    /**
     * @param \JUMA\Bundle\PingBundle\Entity\Team $localTeam
     *
     * @return MatchResult
     */
    public function setLocalTeam(Team $localTeam)
    {
        $this->localTeam = $localTeam;


        return $this;
    }

    /**
     * @return \JUMA\Bundle\PingBundle\Entity\Team
     */
    public function getLocalTeam()
    {
        return $this->localTeam;
    }

    /**
     * @param \JUMA\Bundle\PingBundle\Entity\Team $winnerTeam
     *
     * @return MatchResult
     */
    public function setWinnerTeam(Team $winnerTeam)
    {
        $this->winnerTeam = $winnerTeam;

        return $this;
    }

    /**
     * @return Team
     */
    public function getWinnerTeam()
    {
        return $this->winnerTeam;
    }

    public function getLoserTeam()
    {
        return $this->getWinnerTeam() === $this->getLocalTeam()
            ? $this->getVersusTeam()
            : $this->getLocalTeam();
    }

    /**
     * @return ArrayCollection
     */
    public function getSets()
    {
        return $this->sets;
    }

    /**
     * @param ArrayCollection $sets
     *
     * @return MatchResult
     */
    public function setSets(ArrayCollection $sets)
    {
        $this->sets = $sets;

        return $this;
    }

    /**
     * @param MatchSet $set
     *
     * @return MatchResult
     */
    public function addSet(MatchSet $set)
    {
        $this->getSets()->add($set);

        return $this;
    }

    /**
     * @param MatchSet $set
     *
     * @return MatchResult
     */
    public function removeSet(MatchSet $set)
    {
        $this->getSets()->removeElement($set);

        return $this;
    }
}
