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

        $periodFilterDate = null;

        switch ($period) {
            case "week":
                $periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 week'));
                break;
            case "month":
                $periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 month'));
                break;
            case "year":
                $periodFilterDate = date('Y-m-d H:i:s', strtotime('-12 month'));
                break;
        }

        $query = $entityManager->createQuery('SELECT t FROM App\Entity\Task t WHERE t.client = :clientId AND t.task_state = :taskStateId AND t.creation_date BETWEEN :periodFilterDate AND :today');
        $query->setParameter('clientId', $clientId);
        $query->setParameter('today', date("Y-m-d H:i:s"));
        $query->setParameter('periodFilterDate', $periodFilterDate);
        $query->setParameter('taskStateId', $finishedStateId);
        $tasks = $query->getResult();

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
