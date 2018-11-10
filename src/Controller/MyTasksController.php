<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\EventManager;
use App\Entity\Task;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\TaskState;
use App\Entity\Pomodoro;
use Symfony\Component\Validator\Constraints\Date;

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
            case "name":
                $orderBy['task_name'] = "ASC";
                break;
            case "date":
                $orderBy['creation_date'] = "DESC";
                break;
            case "pomodoros":
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

    /**
     * @param Task $task
     *
     * @Route("/{id}/start-task", requirements={"id" = "\d+"}, name="start_task_route")
     * @return RedirectResponse
     *
     */
    public function startTask(Task $task){

        $activeState = $this->getDoctrine()
        ->getRepository(TaskState::class)
        ->findOneByState('ACTIVE');

        $task->setTaskState($activeState);

        $pomodoroNuevo = new Pomodoro();
        $task->addPomodoro($pomodoroNuevo);

        // Persistiendo
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pomodoroNuevo);
        $entityManager->flush();
        $entityManager->persist($task);
        $entityManager->flush();
        


        /*
        * $active; 
        * $task->setTaskState($active);
        * $pomodoroNuevo;
        * $task->addPomodoro($pomodoroNuevo);
        return $this->redirectToRoute('my_tasks')
        */

        return $this->redirectToRoute('my_tasks');
    }

}
