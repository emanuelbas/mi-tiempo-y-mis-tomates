<?php

namespace App\Controller;

use App\Form\TaskType;
use App\Entity\Task;
use App\Repository\TaskStateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\DBALException;


class TaskController extends AbstractController
{
    /**
     * @Route("/task_creation", name="task_creation")
     */
    public function task_creation(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $error = false;
        $errorMessage = '';

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $entityManager = $this->getDoctrine()->getManager();
                $task->setActive(false);
                $task->setClient( $this->getUser());
                //$task->setTaskState( $entityManager->getRepository('TaskStateRepository:TaskState')->findStateByName('Sin iniciar'));
                $entityManager->persist($task);
                $entityManager->flush();

            } catch (UniqueConstraintViolationException $e) {
                $error = true;
                $errorMessage = $e->getMessage();
            } catch (DBALException $e) {
                $error = true;
                $errorMessage = 'Se produjo un error al intentar crear la tarea.';
            }

            if ($error) {
                return $this->render(
                    'task/create_task.html.twig',
                    array(
                        'form' => $form->createView(),
                        'error' => $errorMessage)
                );
            } else {
                $this->addFlash(
                    'success',
                    'Tu tarea ha sido creada exitosamente.'
                );
                return $this->redirectToRoute('home');
            }
        }

        return $this->render(
            'task/create_task.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $errorMessage)
        );
    }
}