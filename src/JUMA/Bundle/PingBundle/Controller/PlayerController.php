<?php

namespace JUMA\Bundle\PingBundle\Controller;

use HS\PasswordLessBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlayerController extends Controller
{
    public function listAction()
    {
        $players = $this->getDoctrine()->getManager()->getRepository('HSPasswordLessBundle:Player')->findAll();

        $serializer = $this->get('serializer');
        $serializedPlayers = array();
        foreach ($players as $player) {
            $serializedPlayers[] = $serializer->normalize($player, 'json');
        }

        return new JsonResponse($serializedPlayers);
    }

    public function playerRatingsAction(Player $player)
    {
        $history = $this->getDoctrine()
            ->getManager()
            ->getRepository('JUMAPingBundle:RatingHistory')
            ->getPlayerHistory($player);

        return new JsonResponse($history);
    }
}
