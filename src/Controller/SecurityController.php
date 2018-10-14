<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
    * @Route("/login", name="login")
    */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render ('login/index.html.twig', array(
                'last_username' => $lastUsername,
                'error'         => $error,
            ));
    }

    /**
    * @Route("/logout", name="logout")
    */
    public function logout()
    {

    }
}
