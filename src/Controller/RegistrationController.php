<?php

namespace App\Controller;

use App\Form\ClientType;
use App\Entity\Client;
use App\Entity\PomodorosConfiguration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\DBALException;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $error = false;
        $errorMessage = '';

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // 3) Encode the password (you could also do this via Doctrine listener)   
                $password = $passwordEncoder->encodePassword($client, $client->getPassword());
                $client->setPassword($password);

                // 4) Add the default configuration for the pomodoros
                $pomodorosConfiguration = new PomodorosConfiguration();
                $pomodorosConfiguration->setBreakTime(10);
                $pomodorosConfiguration->setWorkingTime(30);
                $pomodorosConfiguration->setEndBreakAlarm(FALSE);
                $pomodorosConfiguration->setEndWorkAlarm(FALSE);
                $pomodorosConfiguration->setClockSound(TRUE); 
                $pomodorosConfiguration->setClient($client);    
                $client->setPomodorosConfiguration($pomodorosConfiguration);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($client);
                $entityManager->persist($pomodorosConfiguration);  
                $entityManager->flush();

            } catch (UniqueConstraintViolationException $e) {
                $error = true;
                $errorMessage = $e->getMessage();
            } catch (DBALException $e) {
                $error = true;
                $errorMessage = 'Se produjo un error al intentar crear la cuenta.';
            }

            if ($error) {
                return $this->render(
                    'registration/register.html.twig',
                    array(
                        'form' => $form->createView(),
                        'error' => $errorMessage)
                );
            } else {
                $this->addFlash(
                    'success',
                    'Tu cuenta ha sido creada exitosamente.'
                );
                return $this->redirectToRoute('login');
            }
        }

        return $this->render(
            'registration/register.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $errorMessage)
        );
    }
}