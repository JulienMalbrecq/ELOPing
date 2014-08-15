<?php

namespace JUMA\Bundle\PingBundle\Controller;

use JUMA\Bundle\PingBundle\Entity\Team;
use JUMA\Bundle\PingBundle\Form\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{
    public function createAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm(new TeamType(), $team);

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($team);
                $em->flush();

                return $this->redirect($this->generateUrl('juma_ping.match_create'));
            }
        }

        return $this->render(
            'JUMAPingBundle:Team:create.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
}
