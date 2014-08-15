<?php

namespace JUMA\Bundle\PingBundle\Controller;

use JUMA\Bundle\PingBundle\Entity\MatchResult;
use JUMA\Bundle\PingBundle\Entity\Team;
use JUMA\Bundle\PingBundle\Form\QuickMatchResultType;
use JUMA\Bundle\PingBundle\Rating\Event\MatchResultEvent;
use JUMA\Bundle\PingBundle\Rating\Event\RatingEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MatchController extends Controller
{
    public function indexAction()
    {
        $matches = $this->getDoctrine()->getManager()
            ->getRepository('JUMAPingBundle:MatchResult')
            ->findAll();

        return $this->render(
            'JUMAPingBundle:Match:index.html.twig',
            array('matches' => $matches)
        );
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new QuickMatchResultType(), array('playDate' => new \DateTime()), array('em' => $em));

        if ($request->isMethod('POST'))
        {
            $form->submit($request);

            if ($form->isValid()) {
                $localTeam = $form->get('localTeam')->getData();
                $versusTeam = $form->get('versusTeam')->getData();
                $winnerTeam = $form->get('winnerTeam')->getData() === 1
                    ? $localTeam
                    : $versusTeam;

                $match = new MatchResult();
                $match
                    ->setPlayDate($form->get('playDate')->getData())
                    ->setLocalTeam($localTeam)
                    ->setVersusTeam($versusTeam)
                    ->setWinnerTeam($winnerTeam);

                $this->get('event_dispatcher')
                    ->dispatch(RatingEvents::BEFORE_PERSIST, new MatchResultEvent($match));

                $em->persist($match);
                $em->flush();

                return $this->redirect($this->generateUrl('juma_ping.match_view', array('id' => $match->getId())));
            }
        }

        return $this->render(
            'JUMAPingBundle:Match:create.html.twig',
            array('form' => $form->createView())
        );
    }

    public function viewAction(MatchResult $match)
    {
        return $this->render(
            'JUMAPingBundle:Match:view.html.twig',
            array('matchResult' => $match)
        );
    }
}
