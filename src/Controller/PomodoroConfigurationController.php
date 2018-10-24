<?php

namespace App\Controller;

use App\Form\PomodoroConfigurationType;
use App\Entity\PomodorosConfiguration;
use App\Repository\PomodoroConfigurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\DBALException;


class PomodoroConfigurationController extends AbstractController
{
    /**
     * @Route("/pomodoro_configuration", name="pomodoro_configuration")
     */
    public function pomodoro_configuration(Request $request)
    {
        $pomodoroConfiguration = new PomodorosConfiguration();
        $form = $this->createForm(PomodoroConfigurationType::class, $pomodoroConfiguration);
        $error = false;
        $errorMessage = '';

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pomodoroConfiguration);
                $entityManager->flush();
            } catch (UniqueConstraintViolationException $e) {
                $error = true;
                $errorMessage = $e->getMessage();
            } catch (DBALException $e) {
                $error = true;
                $errorMessage = 'Se produjo un error al intentar configurar los pomodoros.';
            }

            if ($error) {
                return $this->render(
                    'pomodoro_configuration/index.html.twig',
                    array(
                        'form' => $form->createView(),
                        'error' => $errorMessage)
                );
            } else {
                $this->addFlash(
                    'success',
                    'Tus pomodoros han sido modificados exitosamente.'
                );
                return $this->redirectToRoute('my_tasks');
            }
        }

        //$entityManager = $this->getDoctrine()->getManager();
        //$array=$entityManager->getRepository("App\Entity\PomodorosConfiguration")->findBy(['client' => $client]);
       // $current=current($array);
        return $this->render(
            'pomodoro_configuration/index.html.twig',
            array(
                'form' => $form->createView(),
           //     'working_time' => $array.getWorkingTime(),
         //       'break_time' => $array.getBreakTime(),
                'error' => $errorMessage)
        );
    }
}