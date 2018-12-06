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
	
	
	
	
	

    private function sendEmail ($email) {
        $message = (new \Swift_Message('Reporte de Mi Tiempo y Mis Tomates'))
        ->setFrom('no-reply@mitiempoymistomates.com')
        ->setTo($email)
        ->setBody($this->templating->render('email_report.html.twig'), 'text/html');

        $this->mailer->send($message);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {    
        $clients = $this->entityManager->getRepository("App\Entity\Client")->findAll();
        foreach ($clients as $client){
            $config = $client->getReportFrequency();
            $day = getdate();

            if($config == "Mensual") {
                if($day['mday'] == 1) {
                    $this->sendEmail($client->getEmail());
                }
            } elseif ($config=="Anual"){
                if($day['mon'] == 1) {
                    $this->sendEmail($client->getEmail());
                }
            } else {
                $this->sendEmail($client->getEmail());
            }
        }

        $output->writeln('Enviando emails de reporte..');
    }
	
	
	 public function getTiempoDeSesion()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
          $periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 week'));

 		$periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 week'));
		
		
        $query = $entityManager->createQuery(
            'SELECT  SUM(cua.time_ammount) as suma 
            FROM App\Entity\ClientUsesApplication cua
            WHERE cua.client = :clientId AND cua.start_date BETWEEN :periodFilterDate AND :today 
            GROUP BY cua.id')
            ->setParameter('clientId', $clientId)
            ->setParameter('today', date("Y-m-d H:i:s"))
            ->setParameter('periodFilterDate', $periodFilterDate);

         $suma  = $query->getResult();


        return $this->render('email_report.html.twig', [
            'tiempo' => $suma
            
        ]);
    }
	
	
	 public function getTareas($period, $page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
          $periodFilterDate = date('Y-m-d H:i:s', strtotime('-1 week'));

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
                "usePercentage" => (int) round(($category[1] / $totalCategoriesTime) * 100,2)
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
            array_push($$appsData , [
                "name" => $aplicacion['app_name'],
                "time" => $aplicacion['time']
            ]);
        }

        return $this->render('email_report.html.twig', [
            'aplicaciionesData' => $appsData,
            'tasksData' => [],
           
        ]);
    }
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
