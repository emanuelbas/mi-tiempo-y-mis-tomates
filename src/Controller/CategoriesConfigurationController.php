<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\EventManager;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Application;
use App\Entity\ClientCategoryConfiguration;
use App\Entity\ClientApplicationsConfiguration;

class CategoriesConfigurationController extends AbstractController
{
    /**
     * @Route("/categories/configuration/{page}", name="categories_configuration", defaults={"page"=1})
     */
    public function index($page)
    {
    	$entityManager = $this->getDoctrine()->getManager();

        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $pageLimit = 10;

        //$countFilters = array('client' => $clientId);
        $countFilters = array();
        $applications = $this->getDoctrine()->getRepository(Application::class)->findAll();
        
        $applicationsCount = sizeof($applications);
        $totalPages = ceil($applicationsCount / $pageLimit);

        return $this->render('categories_configuration/index.html.twig', [
            'controller_name' => 'CategoriesConfigurationController', 
            	'applications' => $applications , 
            	'totalPages' => $totalPages , 
            	'currentPage' => $page
        ]);
    }
}
