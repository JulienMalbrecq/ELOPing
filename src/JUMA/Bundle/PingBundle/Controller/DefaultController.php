<?php

namespace JUMA\Bundle\PingBundle\Controller;

use JUMA\Bundle\PingBundle\Entity\MatchResult;
use JUMA\Bundle\PingBundle\Rating\RatingComputer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JUMAPingBundle:Default:index.html.twig', array('name' => $name));
    }
}
