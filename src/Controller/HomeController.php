<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\ClientUsesApplication;
use App\Entity\Client;

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


    public function getTiempoDeSesion($clientId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $client = $entityManager->getRepository("App\Entity\Client")->find($clientId);
        $periodOfTime = $client->getReportFrequency()->getFrequencyName();
        if ($periodOfTime == 'Semanal') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 week'));
        } elseif ($periodOfTime == 'Mensual') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 month'));
        } else {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 year'));
        }
        $query = $entityManager->createQuery(
            'SELECT SUM(cua.time_ammount)
            FROM App\Entity\ClientUsesApplication cua
            WHERE cua.client = :clientId AND cua.start_date BETWEEN :date AND :today')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date('Y-m-d H:i:s', time()))
            ->setParameter('date', $date);

        $suma = $query->getSingleScalarResult();

        return (int)$suma;
    }


    public function getTareas($clientId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $client = $entityManager->getRepository("App\Entity\Client")->find($clientId);
        $periodOfTime = $client->getReportFrequency()->getFrequencyName();
        if ($periodOfTime == 'Semanal') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 week'));
        } elseif ($periodOfTime == 'Mensual') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 month'));
        } else {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 year'));
        }

        $query = $entityManager->createQuery('SELECT t FROM App\Entity\Task t WHERE t.client = :clientId AND t.creation_date BETWEEN :periodOfTime AND :today')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date('Y-m-d H:i:s', time()))
            ->setParameter('periodOfTime', $periodOfTime);
        $tasks = $query->getResult();

        $tasksData = [];

        $totalPomodoros = 0;

        foreach ($tasks as $task) {
            $totalPomodoros += count($task->getPomodoros());
            $tasksData[$task->getTaskName()] = count($task->getPomodoros());
        }

        $result = [$totalPomodoros, $tasksData];

        return $result;

    }


    public function getCategorias($clientId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $client = $entityManager->getRepository("App\Entity\Client")->find($clientId);
        $periodOfTime = $client->getReportFrequency()->getFrequencyName();
        if ($periodOfTime == 'Semanal') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 week'));
        } elseif ($periodOfTime == 'Mensual') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 month'));
        } else {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 year'));
        }

        $query = $entityManager->createQuery(
            'SELECT cat.category_name, SUM(cua.time_ammount)
            FROM App\Entity\ClientUsesApplication cua
            INNER JOIN App\Entity\ClientApplicationsConfiguration cac WITH cua.application = cac.application
            INNER JOIN App\Entity\Category cat WITH cac.category = cat.id
            WHERE cua.client = :clientId AND cua.start_date BETWEEN :periodOfTime AND :today 
            GROUP BY cat.id, cat.category_name')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date('Y-m-d H:i:s', time()))
            ->setParameter('periodOfTime', $periodOfTime);

        $categories = $query->getResult();

        $categoriesData = [];

        $totalCategoriesTime = 0;

        foreach ($categories as $category) {
            $totalCategoriesTime += $category[1];
        }

        foreach ($categories as $category) {
            $categoriesData[$category['category_name']] = (int)round(($category[1] / $totalCategoriesTime) * 100, 2);

        }

        return $categoriesData;
    }


    public function getAplicaciones($clientId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $client = $entityManager->getRepository("App\Entity\Client")->find($clientId);
        $periodOfTime = $client->getReportFrequency()->getFrequencyName();
        if ($periodOfTime == 'Semanal') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 week'));
        } elseif ($periodOfTime == 'Mensual') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 month'));
        } else {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 year'));
        }
        $query = $entityManager->createQuery(
            'SELECT a.app_name , SUM(c.time_ammount)
            FROM App\Entity\ClientUsesApplication c
            INNER JOIN App\Entity\Application a WITH a.id = c.application
            WHERE c.client = :clientId AND c.start_date BETWEEN :periodOfTime AND :today 
            GROUP BY a.id
            ORDER BY c.time_ammount DESC')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date('Y-m-d H:i:s', time()))
            ->setParameter('periodOfTime', $periodOfTime);

        $applications = $query->getResult();

        $appsData = [];
        foreach ($applications as $application) {
            $appsData[$application['app_name']] = $application[1];
        }

        return $appsData;
    }


    /**
     * @Route("/email-test", name="email_test")
     */
    public function email_report_test()
    {
        $connectedTime = $this->getTiempoDeSesion('1');
        $connectedString = gmdate('H', $connectedTime) . 'h ' . gmdate('i', $connectedTime) . 'm';
        $tasksData = $this->getTareas(1);
        $categoriesData = $this->getCategorias(1);
        $appsData = $this->getAplicaciones(1);
        return $this->render('email_report.html.twig', [
            'connectedTime' => $connectedString,
            'tasksData' => $tasksData,
            'appsData' => $appsData,
            'categoriesData' => $categoriesData
        ]);
    }
}