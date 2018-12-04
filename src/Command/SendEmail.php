<?php
// src/Command/SendEmail.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Client;


class SendEmail extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:send-email';

    protected function configure()
    {
        $this
            ->setDescription('Envia un mail')

            ->setHelp('Envia un mail a un usuario dependiendo de su configuracion')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
        $entityManager = $this->getDoctrine()->getManager();

        $clients =$entityManager->getRepository("App\Entity\Client")->findAll();
        foreach ($clients as $client){
            $config = $client->getReportFrequency();
            $day= getdate();
            if($config=="mensual"){
                if($day['mday']== 1){
                    //SENDMAIL
                }
            }elseif ($config=="anual"){
                if($day['mon']== 1){
                //SENDMAIL
            }

            }else{
                //sendmail
            }
        }

        $output->writeln('User successfully generated!');
    }
}