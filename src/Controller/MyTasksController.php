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
     * @Route("/my-tasks/{page}/{state}/{sort}", name="my_tasks",defaults={"page"=1, "state"="all", "sort"=0})
     */
    public function index(Request $request, $page, $state, $sort)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $pageLimit = 5;

        $filters = array('client' => $clientId);
        $orderBy = array();

        $state = strtoupper($state);
        if ($state != "ALL") {
            $stateObj = $entityManager->getRepository("App\Entity\TaskState")->findOneBy(['state' => $state]);
            $stateId = $stateObj->getId();
            $filters['task_state'] = $stateId;
        }
        switch ($sort) {
            case 0:
                $orderBy['task_name'] = "ASC";
                break;
            case 1:
                $orderBy['creation_date'] = "DESC";
                break;
            case 2:
                $orderBy['stimated_pomodoros'] = "DESC";
                break;
        }

        $countFilters = array('client' => $clientId);
        if ($state != "ALL") {
            $countFilters['task_state'] = $stateId;
        }
        /* var_dump($countFilters);*/
        /* var_dump($filters);*/

        $taskCount = $entityManager->getRepository('App\Entity\Task')->count($countFilters);
        $totalPages = ceil($taskCount / $pageLimit);

        $tasks = $entityManager->getRepository("App\Entity\Task")->findBy($filters, $orderBy, $pageLimit, ($page - 1) * $pageLimit);
        return $this->render('my_tasks/index.html.twig', [
            'controller_name' => 'MyTasksController',
            'tasks' => $tasks,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
    }
}
