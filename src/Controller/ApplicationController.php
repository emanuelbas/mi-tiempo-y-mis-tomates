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
    public function app_data($dataJSON, $taskId)
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
     * @Route("/chek_state", name="chek_state")
     */
    public function check_state($taskId)
    {   

        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository("App\Entity\task")->findOneBy(['id' => $taskId]);
        $state = $task->getTaskState();
        $taskState = $entityManager->getRepository("App\Entity\taskState")->findOneBy(['id' => $state->getId()]);
        return $taksState->getState();

    }
    /**
     * @Route("/ask_task", name="ask_task")
     */
    public function ask_task()
    {   
        $entityManager = $this->getDoctrine()->getManager();
        $state= 'ACTIVE';
        $taskState = $entityManager->getRepository("App\Entity\taskState")->findOneBy(['state' => $state]);
        $task = $entityManager->getRepository("App\Entity\task")->findOneBy(['id' => $taskState]);
        if(task == NULL){
            return NULL;
        }
        else{
            return $task->getId();
        }
    }
}
