<?php
namespace App\DataFixtures;

use App\Entity\SecretQuestion;
use App\Entity\Application;
use App\Entity\Client;
use App\Entity\Pomodoro;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Creando 10 preguntas
        for ($i = 0; $i < 10; $i++) {
            $scretQuestion = new SecretQuestion();
            $scretQuestion->setQuestion('¿Pregunta '.$i.'?');
            $manager->persist($scretQuestion);
        }
		
		// Creando 10 aplicaciones
		for ($i = 0; $i < 10; $i++) {
            $application = new Application();
            $application->setAppName('Aplicacion '.$i);
			$application->setAppId($i);
            $manager->persist($application);
        }
		
		// Creando 10 usuarios
		for ($i = 0; $i < 10; $i++) {
            $user = new Client();
            $user->setEmail('email'.$i.'@gmail.com');
			$user->setPassword('1234');
			$user->setFirstName('Nombre'.$i);
			$user->setLastName('Apellido'.$i);
			$user->setSecretAnswer('respuesta secreta '.$i);
            $manager->persist($user);
        }
		
		// Creando pomodoros
		for ($i = 1; $i < 10; $i++) {
            $instance = new Pomodoro();
            $instance->setStartDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-09 15:16"));
			$instance->setEndingDate(\DateTime::createFromFormat('Y-m-d H:i', "2018-09-09 16:16"));
            $manager->persist($instance);
        }
		

        $manager->flush();
    }
}



?>