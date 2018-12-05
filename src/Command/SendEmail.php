<?php
// src/Command/SendEmail.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;


class SendEmail extends Command
{

    private $mailer;
    private $entityManager;

    public function __construct(\Swift_Mailer $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;

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
        ->setBody('- Email de reporte de prueba -');

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
}