<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\EventManager;
use App\Entity\Task;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\TaskState;
use App\Entity\Pomodoro;
use Symfony\Component\Validator\Constraints\Date;

class ClockController extends AbstractController
{
    /**
     * @Route("/clock", name="clock")
     */
    public function index()
    {
        return $this->render('clock/index.html.twig', [
            'controller_name' => 'ClockController',
        ]);
    }


    /**
     * @param Task $task
     *
     * @Route("/{id}/start-Clock", requirements={"id" = "\d+"}, name="start_clock_route")
     * @return RedirectResponse
     *
     */
    public function startClock(Task $task)
    {
    	$client = $this->get('security.token_storage')->getToken()->getUser();
    	$clock = new Clock($client,$task);
    	$client->setClock($clock);
    }
}
