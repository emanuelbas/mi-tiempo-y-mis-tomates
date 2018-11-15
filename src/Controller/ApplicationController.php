<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ClientUsesApplication;
use App\Entity\Client;
use App\Entity\TaskState;

class ApplicationController extends AbstractController
{

    /**
     * @Route("/app_data", name="app_data")
     */
    public function appData($dataJSON, $taskId)
    {   

        //Obtengo la data del JSON
        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($dataJSON, true);
        foreach($data as $application){
            $clientUsesApplication = new ClientUsesApplication();
            $app = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => $application['app_name']]);
            //Si no encuentra una app con ese nombre se le pone una app predeterminada de la bd llamada OTHER
            if($app == NULL){
                $app = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'other']);
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
        $task = $entityManager->getRepository("App\Entity\task")->findOneBy(['id' => $taskId]);
        $state = $task->getTaskState();
        $taskState = $entityManager->getRepository("App\Entity\taskState")->findOneBy(['id' => $state->getId()]);
        return $taksState->getState();

    }
    /**
     * Para el ID de un cliente, encontrar alguna tarea activa
     * @Route("/ask-user-active-task/{id}", name="ask_task")
     */
    public function askUserActiveTask($id)
    {   
        $entityManager = $this->getDoctrine()->getManager();
        $state= 'ACTIVE';
        $client = $entityManager->getRepository("App\Entity\Client")->findOneBy(['id' => $id]);

        if ($client == NULL) {
            return $this->json([
                'success' => "false",
                'message' => "Cliente inválido"
            ]);
        }

        $task = $entityManager->getRepository("App\Entity\task")->findOneBy(['client' => $id]);

        $taskState = $entityManager->getRepository("App\Entity\taskState")->findOneBy(['state' => $state]);
        if(task == NULL){
            return NULL;
        }
        else{
            return $task->getId();
        }
    }
}
