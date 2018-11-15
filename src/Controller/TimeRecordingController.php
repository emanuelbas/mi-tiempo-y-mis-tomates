<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\EventManager;
use App\Entity\Client;


class TimeRecordingController extends AbstractController
{
    /**
     * @Route("/auth", name="auth")
     */
    public function login(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository("App\Entity\Client")->findOneBy(['email' => $request->request->get('email'), 'password' => $request->request->get('password')]);
        
        if ($user === NULL) {
            return $this->json([
                'success' => "false",
                'message' => "Credenciales invalidas"
            ]);
        } else {
        return $this->json([
            'success' => true,
            'message' => 'Credenciales validas',
            'email' => $user->getUsername(),
            'id' => $user->getId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName()
            
        ]);
        }
    }
}