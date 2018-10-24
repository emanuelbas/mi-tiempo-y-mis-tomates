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
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)


    {
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
        $frecuencia1->setFrequencyName('Diaria');
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
        $pconfig->setBreakTime(5);
        $pconfig->setWorkingTime(25);
        $pconfig->setEndWorkAlarm(true);
        $pconfig->setEndBreakAlarm(true);
        $pconfig->setClockSound(true);
        $pconfig->setClient($user);
        $user->setPomodorosConfiguration($pconfig);
        $manager->persist($pconfig);
        $manager->persist($user);

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
        $task1->setTaskState($active);
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

        $user = new Client();
        $user->setEmail('norbertod@gmail.com');
        $user->setPassword('1234');
        $user->setFirstName('Norberto');
        $user->setLastName('Díaz');
        $user->setSecretAnswer('Rojo');
        $manager->persist($user);


        // Creando 10 aplicaciones
        for ($i = 0; $i < 10; $i++) {
            $application = new Application();
            $application->setAppName('Aplicacion ' . $i);
            $application->setAppId($i);
            $manager->persist($application);
        }


        $manager->flush();
    }
}


?>