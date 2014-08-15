<?php

namespace HS\PasswordLessBundle\Entity;

use DateTime;
use HS\PasswordLessBundle\Entity\Player as User;
use Doctrine\ORM\Mapping as ORM;

/**
 * LoginHash
 *
 * @ORM\Table(
 *      name="login_hash",
 *      indexes={
 *          @ORM\Index(name="hash_idx", columns={"hash"}),
 *          @ORM\Index(name="user_hash_idx", columns={"user_id", "hash", "ttl"})
 *      }
 * )
 * @ORM\Entity()
 */
class LoginHash
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="HS\PasswordLessBundle\Entity\Player")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255)
     */
    private $hash;

    /**
     * @var boolean
     *
     * @ORM\Column(name="temporary", type="boolean")
     */
    private $temporary;

    /**
     * @var DateTime
     * @ORM\Column(name="ttl", type="datetime")
     */
    private $ttl;

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
     * @param User $user
     *
     * @return User
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set hash
     *
     * @param string $hash
     * @return LoginHash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param boolean $temporary
     *
     * @return $this
     */
    public function setTemporary($temporary = true)
    {
        $this->temporary = $temporary;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isTemporary()
    {
        return $this->temporary;
    }

    /**
     * @param \DateTime $ttl
     *
     * @return $this
     */
    public function setTTL(DateTime $ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTTL()
    {
        return $this->ttl;
    }
}
