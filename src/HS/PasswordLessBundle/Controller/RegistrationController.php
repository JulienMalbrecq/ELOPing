<?php

namespace HS\PasswordLessBundle\Controller;

use HS\PasswordLessBundle\Entity\Player;
use HS\PasswordLessBundle\Form\RegistrationType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        $player = new Player();
        $form = $this->createForm(new RegistrationType(), $player);

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $registrationHandler = $this->get('hs_passwordless.registration.registration_handler');
                $registrationHandler->registerUser($player);
                return $this->redirect($this->generateUrl('hs_passwordless_request_login'));
            }
        }

        return $this->render(
            'HSPasswordLessBundle:Registration:register.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function confirmRegistrationAction($hash)
    {
    }

}
