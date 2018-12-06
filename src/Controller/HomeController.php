<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\ClientUsesApplication;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("download", name="download")
     */
    public function download()
    {
        return $this->render('download/download.html.twig');
    }

    public function getTiempoDeSesion()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientId = 1;

        $periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 month'));

        $query = $entityManager->createQuery(
            'SELECT SUM(cua.time_ammount)
            FROM App\Entity\ClientUsesApplication cua
            WHERE cua.client = :clientId AND cua.start_date BETWEEN :periodFilterDate AND :today')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date("Y-m-d H:i:s"))
            ->setParameter('periodFilterDate', $periodFilterDate);

        $suma = $query->getSingleScalarResult();

        return (int) $suma;
    }


    public function getTareas($period, $page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 week'));

        $query = $entityManager->createQuery('SELECT t FROM App\Entity\Task t WHERE t.client = :clientId AND t.creation_date BETWEEN :periodFilterDate AND :today')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date("Y-m-d H:i:s"))
            ->setParameter('periodFilterDate', $periodFilterDate);
            //->setFirstResult(($page - 1) * $pageLimit)
            //->setMaxResults($pageLimit);
        $tasks = $query->getResult();

        $tasksData = [];

        foreach ($tasks as $task) {
            array_push($tasksData, [
                "name" => $task->getTaskName(),
                "usedPomodoros" => count($task->getPomodoros())]);
        }


        return $this->render('email_report.html.twig', [

            'tasksData' => $tasksData,
            'chartType' => 'tasks',

        ]);
    }


    public function getCategorias()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 week'));

        $periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 week'));
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
                "usePercentage" => (int)round(($category[1] / $totalCategoriesTime) * 100, 2)
            ]);
        }

        return $this->render('email_report.html.twig', [
            'categoriesData' => $categoriesData,
            'tasksData' => [],
            'chartType' => 'categories'
        ]);
    }


    public function getAplicaciones()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 week'));


        $query = $entityManager->createQuery(
            'SELECT cat.app_name , SUM(cua.time_ammount)as tiempo 
            FROM App\Entity\ClientUsesApplication cua
            INNER JOIN App\Entity\Application ap
            WHERE cua.client = :clientId AND cua.start_date BETWEEN :periodFilterDate AND :today 
            GROUP BY ap.id, ap.app_name')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date("Y-m-d H:i:s"))
            ->setParameter('periodFilterDate', $periodFilterDate);

        $aplicaciones = $query->getResult();

        $appsData = [];
        foreach ($aplicaciones as $aplicacion) {
            array_push($$appsData, [
                "name" => $aplicacion['app_name'],
                "time" => $aplicacion['time']
            ]);
        }

        return $this->render('email_report.html.twig', [
            'aplicacionesData' => $appsData,
            'tasksData' => [],

        ]);
    }


    /**
     * @Route("/email-test", name="email_test")
     */
    public function email_report_test()
    {
        $connectedTime = $this->getTiempoDeSesion();
        return $this->render('email_report.html.twig', [
            'connectedTime' => $connectedTime
        ]);
    }
}