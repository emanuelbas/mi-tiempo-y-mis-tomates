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
     * @Route("/my-tasks/{page}/{state}/{sort}", name="my_tasks",defaults={"page"=0, "state"=0, "sort"=0})
     */
    public function index(Request $request, $page, $state, $sort)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $pageLimit = 5;

        $filters = array('client' => $clientId);
        $orderBy = array();

        if ($state != 0) {
            $filters['task_state'] = $state;
        }
        switch ($sort) {
            case 0:
                $orderBy['task_name'] = "DESC";
                break;
            case 1:
                $orderBy['creation_date'] = "DESC";
                break;
            case 2:
                $orderBy['stimated_pomodoros'] = "DESC";
                break;
        }
  /*      var_dump($filters);
        var_dump($orderBy);*/

        $taskCount = $entityManager->getRepository('App\Entity\Task')->count($state != 0 ? ['task_state' => $state] : []);
        $totalPages = ceil($taskCount / $pageLimit);

        $tasks = $entityManager->getRepository("App\Entity\Task")->findBy($filters, $orderBy, $pageLimit, $page*$pageLimit);
/*        var_dump($totalPages);*/
   /*     var_dump($taskCount);*/
        return $this->render('my_tasks/index.html.twig', [
            'controller_name' => 'MyTasksController',
            'tasks' => $tasks,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
    }
}
