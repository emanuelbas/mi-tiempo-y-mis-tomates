<?php

namespace App\DataFixtures;

use App\Entity\SecretQuestion;
use App\Entity\Application;
use App\Entity\Client;
use App\Entity\Pomodoro;
use App\Entity\PomodorosConfiguration;
use App\Entity\ReportFrequency;
use App\Entity\Task;
use App\Entity\TaskState;
use App\Entity\Category;
use App\Entity\ProductivityLevel;
use App\Entity\ClientApplicationsConfiguration;
use App\Entity\ClientCategoryConfiguration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)


    {

        // Aplicaciones
        $applicationS = new Application();
        $applicationS->setAppName('Spotify');
        $applicationS->setAppId(14);
        $manager->persist($applicationS);
        $applicationG = new Application();
        $applicationG->setAppName('Google Chrome');
        $applicationG->setAppId(13);
        $manager->persist($applicationG);
        $applicationVS = new Application();
        $applicationVS->setAppName('Microsoft Visual Studio 2017');
        $applicationVS->setAppId(12);
        $manager->persist($applicationVS);
        $applicationFF = new Application();
        $applicationFF->setAppName('Mozila Firefox');
        $applicationFF->setAppId(20);
        $manager->persist($applicationFF);
        $applicationBDN = new Application();
        $applicationBDN->setAppName('Bloc de notas');
        $applicationBDN->setAppId(21);
        $manager->persist($applicationBDN);
        $applicationFF1 = new Application();
        $applicationFF1->setAppName('Firefox');
        $applicationFF1->setAppId(22);
        $manager->persist($applicationFF1);
        $applicationHB = new Application();
        $applicationHB->setAppName('HandBrake');
        $applicationHB->setAppId(23);
        $manager->persist($applicationHB);
        $applicationPST = new Application();
        $applicationPST->setAppName('PhpStorm');
        $applicationPST->setAppId(24);
        $manager->persist($applicationPST);
        $applicationVSC = new Application();
        $applicationVSC->setAppName('Visual Studio Code');
        $applicationVSC->setAppId(25);
        $manager->persist($applicationVSC);
        $applicationTWT = new Application();
        $applicationTWT->setAppName('Twitter');
        $applicationTWT->setAppId(26);
        $manager->persist($applicationTWT);
        $applicationFB = new Application();
        $applicationFB->setAppName('Facebook');
        $applicationFB->setAppId(27);
        $manager->persist($applicationFB);

        $applicationIG = new Application();
        $applicationIG->setAppName('Instagram');
        $applicationIG->setAppId(28);
        $manager->persist($applicationIG);

        $applicationGML = new Application();
        $applicationGML->setAppName('Gmail');
        $applicationGML->setAppId(30);
        $manager->persist($applicationGML);

        $applicationGTH = new Application();
        $applicationGTH->setAppName('GitHub');
        $applicationGTH->setAppId(31);
        $manager->persist($applicationGTH);

        $applicationWKP = new Application();
        $applicationWKP->setAppName('Wikipedia');
        $applicationWKP->setAppId(32);
        $manager->persist($applicationWKP);

        $applicationOLX = new Application();
        $applicationOLX->setAppName('OLX');
        $applicationOLX->setAppId(33);
        $manager->persist($applicationOLX);

        $applicationCLR = new Application();
        $applicationCLR->setAppName('Clarin');
        $applicationCLR->setAppId(34);
        $manager->persist($applicationCLR);

        $applicationP12 = new Application();
        $applicationP12->setAppName('Página12');
        $applicationP12->setAppId(35);
        $manager->persist($applicationP12);

        $applicationDED = new Application();
        $applicationDED->setAppName('Diario El Día');
        $applicationDED->setAppId(36);
        $manager->persist($applicationDED);

        $applicationWSP = new Application();
        $applicationWSP->setAppName('WhatsApp');
        $applicationWSP->setAppId(36);
        $manager->persist($applicationWSP);

        $applicationAMZ = new Application();
        $applicationAMZ->setAppName('Amazon');
        $applicationAMZ->setAppId(37);
        $manager->persist($applicationAMZ);

        $applicationML = new Application();
        $applicationML->setAppName('Mercado Libre');
        $applicationML->setAppId(37);
        $manager->persist($applicationML);

        $applicationGS = new Application();
        $applicationGS->setAppName('Google Search');
        $applicationGS->setAppId(37);
        $manager->persist($applicationGS);

        $manager->flush();
        // FIN APLICACIONES //

        // Niveles de productividad
        $productividadAlta = new ProductivityLevel();
        $productividadAlta->setLevelName('Alta');
        $manager->persist($productividadAlta);
        $manager->flush();
        $productividadBaja = new ProductivityLevel();
        $productividadBaja->setLevelName('Baja');
        $manager->persist($productividadBaja);
        $manager->flush();
        $productividadNeutral = new ProductivityLevel();
        $productividadNeutral->setLevelName('Neutral');
        $manager->persist($productividadNeutral);
        $manager->flush();
        // FIN NIVELES //


        // Categorias
        $negocios = new Category('Negocios');
        $manager->persist($negocios);
        $manager->flush();
        $comunicacionYPlanificacion = new Category('Comunicación y planificación');
        $manager->persist($comunicacionYPlanificacion);
        $manager->flush();
        $entretenimientoYRedesSociales = new Category('Entretenimientos y redes sociales');
        $manager->persist($entretenimientoYRedesSociales);
        $manager->flush();
        $diseno = new Category('Diseño');
        $manager->persist($diseno);
        $manager->flush();
        $noticias = new Category('Noticias');
        $manager->persist($noticias);
        $manager->flush();
        $desarrolloDeSoftware = new Category('Desarrollo de software');
        $manager->persist($desarrolloDeSoftware);
        $manager->flush();
        $compras = new Category('Compras');
        $manager->persist($compras);
        $manager->flush();
        $utilidadReferencias = new Category('Utilidad, referencias');
        $manager->persist($utilidadReferencias);
        $manager->flush();
        // FIN CATEGORIAS //

        // Preguntas secretas

        $secretQuestion1 = new SecretQuestion();
        $secretQuestion1->setQuestion('¿Cual es el nombre de tu primer mascota?');
        $manager->persist($secretQuestion1);

        $secretQuestion2 = new SecretQuestion();
        $secretQuestion2->setQuestion('¿Cual es tu comida favorita?');
        $manager->persist($secretQuestion2);

        $secretQuestion3 = new SecretQuestion();
        $secretQuestion3->setQuestion('¿Cual es el nombre de la ciudad en que naciste?');
        $manager->persist($secretQuestion3);
        // FIN PREGUNTAS //

        // Frecuencias de reporte disponibles
        $frecuencia1 = new ReportFrequency();
        $frecuencia1->setFrequencyName('Semanal');
        $manager->persist($frecuencia1);
        $frecuencia2 = new ReportFrequency();
        $frecuencia2->setFrequencyName('Mensual');
        $manager->persist($frecuencia2);
        $frecuencia3 = new ReportFrequency();
        $frecuencia3->setFrequencyName('Anual');
        $manager->persist($frecuencia3);
        // FIN FRECUENCIAS //

        // Estados de las Tareas
        $pending = new TaskState();
        $pending->setState('PENDING');
        $manager->persist($pending);
        $active = new TaskState();
        $active->setState('ACTIVE');
        $manager->persist($active);
        $finished = new TaskState();
        $finished->setState('FINISHED');
        $manager->persist($finished);

        // CREANDO CLIENTES
        $user = new Client();
        $user->setEmail('jorge@gmail.com');
        $user->setPassword('1234');
        $user->setFirstName('Jorge');
        $user->setLastName('Lombardi');
        $user->setSecretQuestion($secretQuestion2);
        $user->setReportFrequency($frecuencia2);
        $user->setSecretAnswer('Pizza');
        $manager->persist($user);

        // - Pomodoros configuration

        $pconfig = new PomodorosConfiguration();
        $user->setPomodorosConfiguration($pconfig);
        $manager->persist($pconfig);
        $manager->persist($user);

        // - Configuraciones de categorias del usuario por defecto
        
        $category = $negocios;
        $productivityLevel = $productividadAlta;
        $cconfig = new ClientCategoryConfiguration($user, $category, $productivityLevel);
        $manager->persist($cconfig);
        $manager->flush();

        $category = $comunicacionYPlanificacion;
        $productivityLevel = $productividadNeutral;
        $cconfig = new ClientCategoryConfiguration($user, $category, $productivityLevel);
        $manager->persist($cconfig);
        $manager->flush();

        $category = $entretenimientoYRedesSociales;
        $productivityLevel = $productividadBaja;
        $cconfig = new ClientCategoryConfiguration($user, $category, $productivityLevel);
        $manager->persist($cconfig);
        $manager->flush();

        $category = $diseno;
        $productivityLevel = $productividadAlta;
        $cconfig = new ClientCategoryConfiguration($user, $category, $productivityLevel);
        $manager->persist($cconfig);
        $manager->flush();

        // Aplicaciones de diseño
        $aconfig = new ClientApplicationsConfiguration($user, $applicationHB, $category);
        $manager->persist($aconfig);
        $manager->flush();

        $category = $noticias;
        $productivityLevel = $productividadBaja;
        $cconfig = new ClientCategoryConfiguration($user, $category, $productivityLevel);
        $manager->persist($cconfig);
        $manager->flush();

        $category = $desarrolloDeSoftware;
        $productivityLevel = $productividadAlta;
        $cconfig = new ClientCategoryConfiguration($user, $category, $productivityLevel);
        $manager->persist($cconfig);
        $manager->flush();

        // Aplicaciones de desarrollo
        $aconfig = new ClientApplicationsConfiguration($user, $applicationPST, $category);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationVS, $category);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationVSC, $category);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationGTH, $category);
        $manager->persist($aconfig); $manager->flush();


        $category = $compras;
        $productivityLevel = $productividadBaja;
        $cconfig = new ClientCategoryConfiguration($user, $category, $productivityLevel);
        $manager->persist($cconfig);
        $manager->flush();

        $category = $utilidadReferencias;
        $productivityLevel = $productividadNeutral;
        $cconfig = new ClientCategoryConfiguration($user, $category, $productivityLevel);
        $manager->persist($cconfig);
        $manager->flush();

        // Aplicaciones de utilidad
        $aconfig = new ClientApplicationsConfiguration($user, $applicationG, $category);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationFF, $category);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationFF1, $category);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationBDN, $category);
        $manager->persist($aconfig); $manager->flush();

        $aconfig = new ClientApplicationsConfiguration($user, $applicationWKP, $category);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationGS, $category);
        $manager->persist($aconfig); $manager->flush();

        // Aplicaciones de comunicación y planificación
        $aconfig = new ClientApplicationsConfiguration($user, $applicationGML, $comunicacionYPlanificacion);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationWSP, $comunicacionYPlanificacion);
        $manager->persist($aconfig); $manager->flush();

        // Aplicaciones de noticias
        $aconfig = new ClientApplicationsConfiguration($user, $applicationDED, $noticias);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationP12, $noticias);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationCLR, $noticias);
        $manager->persist($aconfig); $manager->flush();

        // Aplicaciones de compras
        $aconfig = new ClientApplicationsConfiguration($user, $applicationML, $compras);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationAMZ, $compras);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationOLX, $compras);
        $manager->persist($aconfig); $manager->flush();
    
        // Aplicaciones de entretenimiento
        $aconfig = new ClientApplicationsConfiguration($user, $applicationTWT, $entretenimientoYRedesSociales);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationFB, $entretenimientoYRedesSociales);
        $manager->persist($aconfig); $manager->flush();
        $aconfig = new ClientApplicationsConfiguration($user, $applicationIG, $entretenimientoYRedesSociales);
        $manager->persist($aconfig); $manager->flush();
    
 



































        // - Tareas del usuario

        //Tarea lavar ropa
        $task1 = new Task();
        $task1->setTaskName('Lavar la ropa');
        $task1->setCreationDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-09 15:16"));
        $task1->setStimatedPomodoros(10);
        $task1->setActive(true);
        $task1->setClient($user);
        $task1->setTaskState($pending);
        $manager->persist($user);
        $manager->persist($task1);

        // - - La tarea tiene pomodoros
        $pomodoro = new Pomodoro();
        $pomodoro->setStartDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-09 15:16"));
        $pomodoro->setEndingDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-09 15:36"));
        $pomodoro->setTask($task1);
        $task1->addPomodoro($pomodoro);
        $manager->persist($pomodoro);
        $manager->persist($task1);
        //
        $pomodoro = new Pomodoro();
        $pomodoro->setStartDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-20 12:10"));
        $pomodoro->setEndingDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-20 12:40"));
        $pomodoro->setTask($task1);
        $task1->addPomodoro($pomodoro);
        $manager->persist($pomodoro);
        $manager->persist($task1);
        // FIN POMODOROS

        //Tarea cocinar
        $task1 = new Task();
        $task1->setTaskName('Cocinar sushi para la noche');
        $task1->setCreationDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-4 10:16"));
        $task1->setStimatedPomodoros(2);
        $task1->setActive(true);
        $task1->setClient($user);
        $task1->setTaskState($pending);
        $manager->persist($user);
        $manager->persist($task1);

        // - - La tarea tiene pomodoros
        $pomodoro = new Pomodoro();
        $pomodoro->setStartDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-10 15:16"));
        $pomodoro->setEndingDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-10 15:36"));
        $pomodoro->setTask($task1);
        $task1->addPomodoro($pomodoro);
        $manager->persist($pomodoro);
        $manager->persist($task1);
        //
        $pomodoro = new Pomodoro();
        $pomodoro->setStartDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-20 12:10"));
        $pomodoro->setEndingDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-20 12:40"));
        $pomodoro->setTask($task1);
        $task1->addPomodoro($pomodoro);
        $manager->persist($pomodoro);
        $manager->persist($task1);
        //
        $pomodoro = new Pomodoro();
        $pomodoro->setStartDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-22 12:10"));
        $pomodoro->setEndingDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-22 12:40"));
        $pomodoro->setTask($task1);
        $task1->addPomodoro($pomodoro);
        $manager->persist($pomodoro);
        $manager->persist($task1);
        // FIN POMODOROS



        //Tarea estudiar para el final de mañana
        $task1 = new Task();
        $task1->setTaskName('Estudiar para el final de mañana');
        $task1->setCreationDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-10 10:16"));
        $task1->setStimatedPomodoros(15);
        $task1->setActive(true);
        $task1->setClient($user);
        $task1->setTaskState($finished);
        $manager->persist($user);
        $manager->persist($task1);

        // - - La tarea tiene pomodoros
        $pomodoro = new Pomodoro();
        $pomodoro->setStartDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-10 15:16"));
        $pomodoro->setEndingDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-10 15:36"));
        $pomodoro->setTask($task1);
        $task1->addPomodoro($pomodoro);
        $manager->persist($pomodoro);
        $manager->persist($task1);
        //
        $pomodoro = new Pomodoro();
        $pomodoro->setStartDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-20 12:10"));
        $pomodoro->setEndingDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-20 12:40"));
        $pomodoro->setTask($task1);
        $task1->addPomodoro($pomodoro);
        $manager->persist($pomodoro);
        $manager->persist($task1);
        //
        $pomodoro = new Pomodoro();
        $pomodoro->setStartDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-22 12:10"));
        $pomodoro->setEndingDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-22 12:40"));
        $pomodoro->setTask($task1);
        $task1->addPomodoro($pomodoro);
        $manager->persist($pomodoro);
        $manager->persist($task1);
        // FIN POMODOROS


        $user = new Client();
        $user->setEmail('lucia@gmail.com');
        $user->setPassword('1234');
        $user->setFirstName('Lucia');
        $user->setLastName('Gómez');
        $user->setSecretAnswer('La plata');
        $manager->persist($user);

        $pconfig = new PomodorosConfiguration();
        $user->setPomodorosConfiguration($pconfig);
        $manager->persist($pconfig);
        $manager->persist($user);

        $user = new Client();
        $user->setEmail('norbertod@gmail.com');
        $user->setPassword('1234');
        $user->setFirstName('Norberto');
        $user->setLastName('Díaz');
        $user->setSecretAnswer('Rojo');
        $pconfig->setClient($user);
        $manager->persist($user);

        $pconfig = new PomodorosConfiguration();
        $user->setPomodorosConfiguration($pconfig);
        $manager->persist($pconfig);
        $manager->persist($user);

        $manager->flush();

    }
}


?>