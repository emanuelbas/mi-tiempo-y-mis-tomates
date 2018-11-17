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
use App\Entity\Clock;
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

        //Iniciando el reloj
        $client = $this->get('security.token_storage')->getToken()->getUser();
        $clock = new Clock($client,$task);
        $client->setClock($clock);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($task);
        $entityManager->persist($clock);
        $entityManager->persist($client);
        $entityManager->flush();

        return $this->redirectToRoute('my_tasks');
    }


    /**
     * @param Task $task
     *
     * @Route("/{id}/stop-task", requirements={"id" = "\d+"}, name="stop_task_route")
     * @return RedirectResponse
     *
     */
    public function stopTask(Task $task){

        $entityManager = $this->getDoctrine()->getManager();

        /* Destruir el reloj sin guardar datos del ciclo actual */
        $client = $this->get('security.token_storage')->getToken()->getUser();
        $clock = $client->getClock();

        /* Cambiar el estado de la tarea a pendiente */
        $pendingState = $this->getDoctrine()
        ->getRepository(TaskState::class)
        ->findOneByState('PENDING');
        $task->setTaskState($pendingState);
     

        $entityManager->persist($client);
        $entityManager->flush();

        $entityManager->persist($task);
        $entityManager->flush();

        $entityManager->remove($clock);
        $entityManager->flush();






        return $this->redirectToRoute('my_tasks');
    }

    /**
     * @param Task $task
     *
     * @Route("/{id}/finish-task", requirements={"id" = "\d+"}, name="finish_task_route")
     * @return RedirectResponse
     *
     */
    public function finishTask(Task $task){

        $entityManager = $this->getDoctrine()->getManager();

        /* Destruir el reloj sin guardar datos del ciclo actual */
        $client = $this->get('security.token_storage')->getToken()->getUser();
        $clock = $client->getClock();

        /* Cambiar el estado de la tarea a terminada */
        $finishedState = $this->getDoctrine()
        ->getRepository(TaskState::class)
        ->findOneByState('FINISHED');
        $task->setTaskState($finishedState);
     
        $entityManager->persist($client);
        $entityManager->flush();

        $entityManager->persist($task);
        $entityManager->flush();

        $entityManager->remove($clock);
        $entityManager->flush();


        return $this->redirectToRoute('my_tasks');
    }


    /**
     *
     * @Route("/pause-task", name="pause_task_route")
     * @return RedirectResponse
     *
     */
    public function pauseTask(){

        $entityManager = $this->getDoctrine()->getManager();

        /* Pedir al reloj que se pause */
        $client = $this->get('security.token_storage')->getToken()->getUser();
        $clock = $client->getClock();
        $clock->pause();

        $entityManager->persist($clock);
        $entityManager->flush();


        return $this->redirectToRoute('my_tasks');
    }

    /**
     *
     * @Route("/resume-task", name="resume_task_route")
     * @return RedirectResponse
     *
     */
    public function resumeTask(){

        $entityManager = $this->getDoctrine()->getManager();

        /* Pedir al reloj que se pause */
        
        $client = $this->get('security.token_storage')->getToken()->getUser();
        $clock = $client->getClock();
        $clock->resume();

        $entityManager->persist($clock);
        $entityManager->flush();

        return $this->redirectToRoute('my_tasks');
    }

}
