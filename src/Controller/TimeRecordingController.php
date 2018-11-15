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

     /**
     * @Route("/log_time", name="log_time")
     */
    public function log_time(Request $request)
    {
        $programs = $request->request->get('programs');
        var_dump($programs);
        return $this->json([
            'success' => true,
            'message' => "Tiempo registrado correctamente"
        ]); 
    }

       /**
     * @Route("/check-pending-actions", name="check_pending_actions")
     */
    public function check_pending_actions(Request $request)
    {
        $programs = $request->request->get('programs');
        var_dump($programs);
        return $this->json([
            'success' => "true",
            'message' => "Tiempo registrado correctamente"
        ]); 
    }
}