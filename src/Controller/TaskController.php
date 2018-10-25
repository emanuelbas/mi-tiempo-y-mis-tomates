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
                if($task->getStimatedPomodoros()>0){
                    $entityManager = $this->getDoctrine()->getManager();
                    $task->setActive(false);
                    $task->setClient( $this->getUser());
                    $state=$entityManager->getRepository("App\Entity\TaskState")->findBy(['state' => 'PENDING']);
                    $task->setTaskState( current($state));
                    $dateC = date_create();
                    $task->setCreationDate(date_timestamp_set($dateC, time()));
                    $entityManager->persist($task);
                    $entityManager->flush();
                }else{
                    $error = true;
                    $errorMessage = 'Agrege un numero mayor a 0 de pomodoros';
                }
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
                    'Su tarea ha sido creada exitosamente.'
                );
                return $this->redirectToRoute('my_tasks');
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