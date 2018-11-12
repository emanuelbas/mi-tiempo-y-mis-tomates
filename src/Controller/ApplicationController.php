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
     * @Route("/start", name="start")
     */
    public function start( $task)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        //Falta el mensaje a la app y comenzar el reloj.
        //curl('http://127.0.0.1:PUERTO_DE_LA_APP_WINDOWS', POST, [accion=> "empeza_a_registrar"])
 
        $ch = curl_init();
        //envio del mensaje. Poner el puerto correspondiente de la app
        curl_setopt($ch, CURLOPT_URL,"http://127.0.0.1:PUERTO_DE_LA_APP_WINDOWS");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "postuserId=$clientId");

        //recibir mensaje de la app antes de continuar
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);        
        curl_close ($ch);
        //Cambiar estado de tarea a ACTIVE

        // Para preguntar por la respuesta de la app
        //if ($server_output == "OK") { ... } else { ... }
        $state = $entityManager->getRepository("App\Entity\TaskState")->findOneBy(['state' => 'ACTIVE']);
        $task->setTaskState($state);
        $entityManager->persist($task);
        $entityManager->flush();

    }

    /**
     * @Route("/pause", name="pause")
     */
    public function pause($dataJSON, $task)
    {  //Falta parar el reloj

        //Obtengo la data del JSON
        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($dataJSON, true);
        foreach($data as $application => $time){
            $clientUsesApplication = new ClientUsesApplication();
            $app = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => $application]);
            //Si no encuentra una app con ese nombre se le pone una app predeterminada de la bd llamada OTHER
            if($app == NULL){
                $app = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'other']);
            }
            $clientUsesApplication->setApplication($app);
            $clientUsesApplication->setTimeAmount($time);
            $client = $this->get('security.token_storage')->getToken()->getUser();
            $clientUsesApplication->setClient($client);
            $entityManager->persist($clientUsesApplication);
            //No se si el flush iria fuera del foreach
            $entityManager->flush();
        }

        //Cambiar estado de la tarea de ACTIVE a PAUSED
        //Hay que agregar el estado PAUSED a los fixtures
        $actualTask = json_decode($task, true);
        $state = $entityManager->getRepository("App\Entity\TaskState")->findOneBy(['state' => 'PAUSED']);
        $actualTask->setTaskState($state);
        $entityManager->persist($actualTask);
        //Aca lo mismo que en el foreach. No se si con hacer un solo flush se persiste todo. Creo
        //que si.
        $entityManager->flush();

    }


    /**
     * @Route("/stop", name="stop")
     */
    public function stop($dataJSON, $task)
    {   
        //Falta parar el reloj y cambiar el estado de la tarea.

        //Obtengo la data del JSON
        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($dataJSON, true);
        foreach($data as $application => $time){
            $clientUsesApplication = new ClientUsesApplication();
            $app = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => $application]);
            //Si no encuentra una app con ese nombre se le pone una app predeterminada de la bd llamada OTHER
            if($app == NULL){
                $app = $entityManager->getRepository("App\Entity\Application")->findOneBy(['app_name' => 'other']);
            }
            $clientUsesApplication->setApplication($app);
            $clientUsesApplication->setTimeAmount($time);
            $client = $this->get('security.token_storage')->getToken()->getUser();
            $clientUsesApplication->setClient($client);
            $entityManager->persist($clientUsesApplication);
            //No se si el flush iria fuera del foreach
            $entityManager->flush();
        }

        //Cambiar estado de la tarea de ACTIVE a FINISHED
        //Aca agregue el parametro task para que se sepa que tarea es utilizada. No se como querras
        //manejarlo con la app, si como un STRING con el nombre de la tarea o el objeto TASK. Para
        //mi lo mejor es mandar el objeto task.
        $actualTask = json_decode($task, true);
        $state = $entityManager->getRepository("App\Entity\TaskState")->findOneBy(['state' => 'FINISHED']);
        $actualTask->setTaskState($state);
        $entityManager->persist($actualTask);
        //Aca lo mismo que en el foreach. No se si con hacer un solo flush se persiste todo. Creo
        //que si.
        $entityManager->flush();
    }
}
