<?php
// src/Command/SendEmail.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SendEmail extends Command
{

    private $mailer;
    private $entityManager;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, EntityManagerInterface $entityManager, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->templating = $templating;

        // you *must* call the parent constructor
        parent::__construct();
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:send-email';

    protected function configure()
    {
        $this
            ->setDescription('Envia un mail')
            ->setHelp('Envia un mail a un usuario dependiendo de su configuracion');
    }

    private function sendEmail($clientId, $email)
    {
        $connectedTime = $this->getTiempoDeSesion($clientId);
        $connectedString = gmdate('H', $connectedTime) . 'h ' . gmdate('i', $connectedTime) . 'm';
        $tasksData = $this->getTareas($clientId);
        $categoriesData = $this->getCategorias($clientId);
        $appsData = $this->getAplicaciones($clientId);

        $message = (new \Swift_Message('Reporte de Mi Tiempo y Mis Tomates'))
            ->setFrom('no-reply@mitiempoymistomates.com')
            ->setTo($email)
            ->setBody($this->templating->render('email_report.html.twig', [
                'connectedTime' => $connectedString,
                'tasksData' => $tasksData,
                'appsData' => $appsData,
                'categoriesData' => $categoriesData
            ]), 'text/html');

        $this->mailer->send($message);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $clients = $this->entityManager->getRepository("App\Entity\Client")->findAll();
        foreach ($clients as $client) {
            //$this->sendEmail($client->getId(), $client->getEmail());

            $config = $client->getReportFrequency();
            $day = getdate();

            if ($config == "Mensual") {
                if ($day['mday'] == 1) {
                    $this->sendEmail($client->getId(), $client->getEmail());
                }
            } elseif ($config == "Anual") {
                if ($day['mon'] == 1) {
                    $this->sendEmail($client->getId(), $client->getEmail());
                }
            } else {
                $this->sendEmail($client->getId(), $client->getEmail());
            }
        }

        $output->writeln('Enviando emails de reporte..');
    }


    public function getTiempoDeSesion($clientId)
    {
        $client = $this->entityManager->getRepository("App\Entity\Client")->find($clientId);
        $periodOfTime = $client->getReportFrequency()->getFrequencyName();
        if ($periodOfTime == 'Semanal') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 week'));
        } elseif ($periodOfTime == 'Mensual') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 month'));
        } else {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 year'));
        }
        $query = $this->entityManager->createQuery(
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
        $client = $this->entityManager->getRepository("App\Entity\Client")->find($clientId);
        $periodOfTime = $client->getReportFrequency()->getFrequencyName();
        if ($periodOfTime == 'Semanal') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 week'));
        } elseif ($periodOfTime == 'Mensual') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 month'));
        } else {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 year'));
        }

        $query = $this->entityManager->createQuery('SELECT t FROM App\Entity\Task t WHERE t.client = :clientId AND t.creation_date BETWEEN :periodOfTime AND :today')
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
        $client = $this->entityManager->getRepository("App\Entity\Client")->find($clientId);
        $periodOfTime = $client->getReportFrequency()->getFrequencyName();
        if ($periodOfTime == 'Semanal') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 week'));
        } elseif ($periodOfTime == 'Mensual') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 month'));
        } else {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 year'));
        }

        $query = $this->entityManager->createQuery(
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
        $client = $this->entityManager->getRepository("App\Entity\Client")->find($clientId);
        $periodOfTime = $client->getReportFrequency()->getFrequencyName();
        if ($periodOfTime == 'Semanal') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 week'));
        } elseif ($periodOfTime == 'Mensual') {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 month'));
        } else {
            $date = date("m/d/Y h:i:s A T", strtotime('-1 year'));
        }
        $query = $this->entityManager->createQuery(
            'SELECT a.app_name , SUM(c.time_ammount)
            FROM App\Entity\ClientUsesApplication c
            INNER JOIN App\Entity\Application a WITH a.id = c.application
            WHERE c.client = :clientId AND c.start_date BETWEEN :periodOfTime AND :today 
            GROUP BY a.id')
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
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
