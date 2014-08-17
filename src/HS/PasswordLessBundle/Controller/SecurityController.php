<?php

namespace HS\PasswordLessBundle\Controller;

use HS\PasswordLessBundle\Entity\LoginHash;
use HS\PasswordLessBundle\Form\LoginRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginRequestAction(Request $request)
    {
        $form = $this->createForm(new LoginRequestType());

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $email = $form->get('email')->getData();
                $user = $em->getRepository('HSPasswordLessBundle:Player')
                    ->findOneBy(array('email' => $email));

                if ($user) {
                    $this->get('hs_passwordless.security.authentication.login_request_processor')
                        ->processUserRequest($user);
                    $em->flush();
                }

                return $this->redirect($this->generateUrl('juma_ping_homepage', array('name' => 'juma')));
            }
        }

        return $this->render(
            'HSPasswordLessBundle:Security:login.html.twig',
            array(
                'form' => $form->createView(),
            ));
    }

    public function confirmLoginAction(Request $request, LoginHash $loginHash)
    {
        $now = new \DateTime();
        if ($loginHash->getTTL() <= $now || !$loginHash->isTemporary()) {
            throw $this->createNotFoundException('loginHashNotFound');
        }

        $updated = $this->get('hs_passwordless.security.authentication.login_request_processor')->confirmUserToken($loginHash);
        if ($updated) {
            $request->attributes->set('login_hash_updated', $loginHash);
        }

        return $this->redirect($this->generateUrl('juma_ping_homepage'));
    }
}
