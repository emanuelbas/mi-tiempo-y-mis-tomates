<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\ClientUsesApplication;
use App\Entity\ClientApplicationsConfiguration;
use App\Entity\Task;

class AppTimesReportController extends AbstractController
{
    /**
     * @Route("/my-reports/tasks/{period}/{page}", name="my_reports_tasks", defaults={"period"="week", "page"=1})
     */
    public function tasksStatistics($period, $page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
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

        $pageLimit = 5;
        $queryTaskCount = $entityManager->createQuery('SELECT COUNT(t) FROM App\Entity\Task t WHERE t.client = :clientId AND t.creation_date BETWEEN :periodFilterDate AND :today')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date("Y-m-d H:i:s"))
            ->setParameter('periodFilterDate', $periodFilterDate);

        $taskCount = $queryTaskCount->getSingleScalarResult();

        $totalPages = ceil($taskCount / $pageLimit);

        $query = $entityManager->createQuery('SELECT t FROM App\Entity\Task t WHERE t.client = :clientId AND t.creation_date BETWEEN :periodFilterDate AND :today')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date("Y-m-d H:i:s"))
            ->setParameter('periodFilterDate', $periodFilterDate)
            ->setFirstResult(($page - 1) * $pageLimit)
            ->setMaxResults($pageLimit);
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
            'chartType' => 'tasks',
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'categoriesData' => []
        ]);
    }

    /**
     * @Route("/my-reports/categories/{period}", name="my_reports_categories", defaults={"period"="week"})
     */
    public function categoriesStatistics($period)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
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

        $query = $entityManager->createQuery(
            'SELECT cat.category_name, SUM(cua.time_ammount)
            FROM App\Entity\ClientUsesApplication cua
            INNER JOIN App\Entity\ClientApplicationsConfiguration cac WITH cua.application = cac.application
            INNER JOIN App\Entity\Category cat WITH cac.category = cat.id
            WHERE cua.client = :clientId AND cua.start_date BETWEEN :periodFilterDate AND :today 
            GROUP BY cat.id, cat.category_name')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date("Y-m-d H:i:s"))
            ->setParameter('periodFilterDate', $periodFilterDate);

        $categories = $query->getResult();

        $categoriesData = [];

        $totalCategoriesTime = 0;

        foreach ($categories as $category) {
            $totalCategoriesTime += $category[1];
        }

        foreach ($categories as $category) {
            array_push($categoriesData, [
                "name" => $category['category_name'],
                "usePercentage" => (int) round(($category[1] / $totalCategoriesTime) * 100,2)
            ]);
        }

        return $this->render('app_times_report/index.html.twig', [
            'categoriesData' => $categoriesData,
            'tasksData' => [],
            'chartType' => 'categories'
        ]);
    }
}
