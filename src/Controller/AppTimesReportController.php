<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ClientUsesApplication;

class AppTimesReportController extends AbstractController
{
    /**
     * @Route("/app-times-report", name="app_times_report")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();

        $appData = $entityManager->getRepository("App\Entity\ClientUsesApplication")->findBy(["client" => $clientId]);

        return $this->render('app_times_report/index.html.twig', [
            'appData' => $appData,
        ]);
    }
}
