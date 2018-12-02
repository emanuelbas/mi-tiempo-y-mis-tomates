<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ClientUsesApplication;
use App\Entity\Task;

class AppTimesReportController extends AbstractController
{
    /**
     * @Route("/my-reports/{period}", name="my_reports", defaults={"period"="week"})

     */
    public function index($period)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $finishedStateId = $entityManager->getRepository("App\Entity\TaskState")
            ->findBy(["state" => "FINISHED"]);

        switch ($period) {
            case "week":
                $orderBy['task_name'] = "ASC";
                break;
            case "month":
                $orderBy['creation_date'] = "DESC";
                break;
            case "year":
                $orderBy['stimated_pomodoros'] = "DESC";
                break;
        }

        $tasks = $entityManager->getRepository("App\Entity\Task")
            ->findBy(["client" => $clientId, "task_state" => $finishedStateId]);

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
