<?php

namespace JUMA\Bundle\PingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatchSet
 *
 * @ORM\Table(name="match_set")
 * @ORM\Entity
 */
class MatchSet
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
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="JUMA\Bundle\PingBundle\Entity\Team")
     * @ORM\JoinColumn(name="local_team_id", referencedColumnName="id", nullable=false)
     */
    private $localTeam;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="JUMA\Bundle\PingBundle\Entity\Team")
     * @ORM\JoinColumn(name="versus_team_id", referencedColumnName="id", nullable=false)
     */
    private $versusTeam;

    /**
     * @var integer
     *
     * @ORM\Column(name="local_score", type="integer")
     */
    private $localScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="versus_score", type="integer")
     */
    private $versusScore;

    /**
     * @var MatchResult
     *
     * @ORM\ManyToOne(targetEntity="JUMA\Bundle\PingBundle\Entity\MatchResult", inversedBy="sets")
     * @ORM\JoinColumn(name="match_result_id", referencedColumnName="id", nullable=false)
     */
    private $match;

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
     * Set localScore
     *
     * @param integer $localScore
     * @return MatchSet
     */
    public function setLocalScore($localScore)
    {
        $this->localScore = $localScore;

        return $this;
    }

    /**
     * Get localScore
     *
     * @return integer 
     */
    public function getLocalScore()
    {
        return $this->localScore;
    }

    /**
     * Set versusScore
     *
     * @param integer $versusScore
     * @return MatchSet
     */
    public function setVersusScore($versusScore)
    {
        $this->versusScore = $versusScore;

        return $this;
    }

    /**
     * Get versusScore
     *
     * @return integer 
     */
    public function getVersusScore()
    {
        return $this->versusScore;
    }

    /**
     * @param \JUMA\Bundle\PingBundle\Entity\Team
     *
     * @return MatchSet
     */
    public function setVersusTeam(Team $versusTeam)
    {
        $this->versusTeam = $versusTeam;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersusTeam()
    {
        return $this->versusTeam;
    }

    /**
     * @param \JUMA\Bundle\PingBundle\Entity\Team $localTeam
     *
     * @return MatchSet
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
     * @param \JUMA\Bundle\PingBundle\Entity\MatchResult $match
     *
     * @return MatchSet
     */
    public function setMatch(MatchResult $match)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * @return \JUMA\Bundle\PingBundle\Entity\MatchResult
     */
    public function getMatch()
    {
        return $this->match;
    }
}
