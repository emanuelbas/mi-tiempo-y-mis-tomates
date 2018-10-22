<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\EventManager;
use App\Entity\Task;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;

class MyTasksController extends AbstractController
{
    /**
     * @Route("/my-tasks/{page}/{state}/{sort}", name="my_tasks",defaults={"page"=1, "state"=0, "sort"=0})
     */
    public function index(Request $request, $page, $state, $sort)
    {
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $entityManager = $this->getDoctrine()->getManager();
        if ($state == 0) { // Ver todos
            $tasks = $entityManager->getRepository("App\Entity\Task")->findBy(['client' => $clientId],[],2,$page);
        } else { // Pendiente o finalizado
            $tasks = $entityManager->getRepository("App\Entity\Task")->findBy(['task_state' => $state, 'client' => $clientId]);
        }

        return $this->render('my_tasks/index.html.twig', [
            'controller_name' => 'MyTasksController',
            'tasks' => $tasks
        ]);
    }
}
