<?php


namespace JUMA\Bundle\PingBundle\Entity;


interface RatedInterface
{
    public function getRating();
    public function setRating($rating);
}
