<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ClientUsesApplication;
use App\Entity\Task;

class AppTimesReportController extends AbstractController
{
    /**
     * @Route("/my-reports", name="my_reports")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();

        $tasks = $entityManager->getRepository("App\Entity\Task")
            ->findBy(["client" => $clientId]);

        $tasksData = [];

        foreach ($tasks as $task) {
            array_push($tasksData, [
                "name" => $task->getTaskName(),
                "estimatedPomodoros" => $task->getStimatedPomodoros(),
                "usedPomodoros" => count($task->getPomodoros())]);
        }

        return $this->render('app_times_report/index.html.twig', [
            'tasksData' => $tasksData,
        ]);
    }
}
