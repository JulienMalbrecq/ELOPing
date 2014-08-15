<?php

namespace JUMA\Bundle\PingBundle\Controller;

use HS\PasswordLessBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RatingController extends Controller
{
    public function listAction()
    {
        // get ordered players
        $em = $this->getDoctrine()->getManager();
        $playerRatings = $em->getRepository('HSPasswordLessBundle:Player')->getOrderedPlayerRatings();

        return $this->render(
            'JUMAPingBundle:Rating:list.html.twig',
            array('ratings' => $playerRatings)
        );
    }

    public function playerAction(Player $player)
    {
        // get ordered players
        $em = $this->getDoctrine()->getManager();
        $history = $em->getRepository('JUMAPingBundle:RatingHistory')->getPlayerHistory($player);

        $dataset = array();
        foreach ($history as $entry) {
            $dataset[] = $entry['rating'];
        }


        return $this->render(
            'JUMAPingBundle:Rating:player.html.twig',
            array(
                'player' => $player,
                'history' => $history,
                'dataset' => $dataset
            )
        );
    }

}
