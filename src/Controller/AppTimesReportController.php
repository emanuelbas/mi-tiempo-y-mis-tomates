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

        //Esta levantando las tareas que fueron creadas en el periodo seleccionado
        //Lo que debería hacer es levantar las tareas que contengan algún Pomo
        //En el periodo
        $queryTaskCount = $entityManager->createQuery('SELECT COUNT(DISTINCT t.id) FROM App\Entity\Task t INNER JOIN App\Entity\Pomodoro p WITH p.task = t.id WHERE t.client = :clientId AND p.ending_date BETWEEN :periodFilterDate AND :today')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date("Y-m-d H:i:s"))
            ->setParameter('periodFilterDate', $periodFilterDate);

        $taskCount = $queryTaskCount->getSingleScalarResult();

        $totalPages = ceil($taskCount / $pageLimit);

        $query = $entityManager->createQuery('SELECT t FROM App\Entity\Task t INNER JOIN App\Entity\Pomodoro p WITH p.task = t.id WHERE t.client = :clientId AND p.ending_date BETWEEN :periodFilterDate AND :today GROUP BY t.id' )
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date("Y-m-d H:i:s"))
            ->setParameter('periodFilterDate', $periodFilterDate)
            ->setFirstResult(($page - 1) * $pageLimit)
            ->setMaxResults($pageLimit);
        $tasks = $query->getResult();

        $tasksData = [];


        foreach ($tasks as $task) {

            $estimadosParaEstePeriodo = ($task->getStimatedPomodoros() - count($task->getPomodorosOlderThan($periodFilterDate)));
            if ($estimadosParaEstePeriodo < 0) $estimadosParaEstePeriodo = 0;

            $totalDePomodorosRealizadosEnEstePeriodo = (count($task->getPomodorosNewerThan($periodFilterDate)));

            array_push($tasksData, [
                "name" => $task->getTaskName(),
                "estimatedPomodoros" => $estimadosParaEstePeriodo,
                "usedPomodoros" => $totalDePomodorosRealizadosEnEstePeriodo
                ]);
            //usedPomodoros deberían ser solo los que se usaron durante este periodo
            //estimatedPomodoros imagino que es la linea que separa los malos pomodoros de los buenos, entonces deberia ser task.stimatedPomodoros menos la suma de todos los pomos que se hicieron antes del periodo seleccionado
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
