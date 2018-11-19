<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\ClientUsesApplication;
use App\Entity\Client;
use App\Entity\TaskState;

class ApplicationController extends AbstractController
{

    /**
     * @Route("/log-app-data", name="app_data")
     */
    public function appData(Request $request)
    {   
        $dataJSON = $request->request->get('programs'); // Aca tenes que obtener los programas enviados por POST que se deberia llamar "programs" 
        //Obtengo la data del JSON
        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($dataJSON, true);
        foreach($data as $application){
            $clientUsesApplication = new ClientUsesApplication();
            $app = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => $application['app_name']]);
            //Si no encuentra una app con ese nombre se le pone una app predeterminada de la bd llamada OTHER
            if($app == NULL){
                $app = $entityManager->getRepository('App\Entity\Application')->findOneBy(['app_name' => 'other']);
            }
            $clientUsesApplication->setApplication($app);
            $clientUsesApplication->setTimeAmount($application['minutes']);
            $client = $this->get('security.token_storage')->getToken()->getUser();
            $clientUsesApplication->setClient($client);
            //$task = $entityManager->getRepository("App\Entity\task")->findOneBy(['id' => $taskId]);
            //$clientUsesApplication->setTask($task);

            $entityManager->persist($clientUsesApplication);
            //No se si el flush iria fuera o dentro del foreach
            $entityManager->flush();
        }
    }

    /**
     * @Route("/check-task-state/{taskId}", name="check_task_state")
     */
    public function checkTaskState($taskId)
    {   

        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository('App\Entity\Task')->findOneBy(['id' => $taskId]);
        if($task == NULL){
            return new Response( "No existe la tarea");
        }
        $state = $task->getTaskState();
        $taskState = $entityManager->getRepository('App\Entity\TaskState')->findOneBy(['id' => $state->getId()]);
        if($taskState == NULL){
            return $this->json([
                'success' => false,
                'message' => "Error en el estado de tarea",
            ]);
        } else {
            return $this->json([
                'success' => true,
                'message' => "Estado de la tarea",
                'state' => $taskState->getState()
            ]);
        }

    }
    /**
     * @Route("/ask-task/{clientId}", name="ask_task")
     */
    public function askUserActiveTask($clientId)
    {   
        $entityManager = $this->getDoctrine()->getManager();
        $state= 'ACTIVE';
        $client = $entityManager->getRepository('App\Entity\Client')->findOneBy(['id' => $clientId]);
        $taskState = $entityManager->getRepository('App\Entity\TaskState')->findOneBy(['state' => $state]);
        $task = $entityManager->getRepository('App\Entity\Task')->findOneBy(['task_state' => $taskState, 'client'=>$client]);
        if($task == NULL){
            return $this->json([
                'success' => false,
                'message' => "No hay cambios de tarea",
            ]); 
        } else {
            return $this->json([
                'success' => true,
                'message' => "Estado de tarea",
                'taskId' => $task->getId(),
                'taskName' => $task->getTaskName()
            ]); 
        }
    }
}
