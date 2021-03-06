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
use App\Entity\ProductivityLevel;
use App\Entity\Category;

class CategoriesConfigurationController extends AbstractController
{
    /**
     * @Route("/categories/configuration/{page}", name="categories_configuration", defaults={"page"=1})
     */
    public function index($page)
    {
    	$entityManager = $this->getDoctrine()->getManager();

        $clientId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $pageLimit = 5;

        //$countFilters = array('client' => $clientId);
        $countFilters = array();
        $appConfigurations = $this->getDoctrine()->getRepository(ClientApplicationsConfiguration::class)->findBy(array('client' => $clientId));

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $levels = $this->getDoctrine()->getRepository(ProductivityLevel::class)->findAll();

        $applicationsCount = sizeof($appConfigurations);
        $totalPages = ceil($applicationsCount / $pageLimit);

        $appConfigurations = $this->getDoctrine()->getRepository(ClientApplicationsConfiguration::class)->findBy(array('client' => $clientId), null, $pageLimit, ($page - 1) * $pageLimit);

        return $this->render('categories_configuration/index.html.twig', [
            'controller_name' => 'CategoriesConfigurationController', 
            	'appConfigurations' => $appConfigurations , 
            	'totalPages' => $totalPages , 
            	'currentPage' => $page ,
                'categories' => $categories ,
                'levels' => $levels
        ]);
    }


    /**
     * 
     * @Route("/{app}/{category}/change-category", name="change_category_route")
     * @return RedirectResponse
     *
     */
    public function changeAppCategory(String $app, String $category){

        $entityManager = $this->getDoctrine()->getManager();

        /* Recuperar la configuracion cliente/aplicacion */
        $client = $this->get('security.token_storage')->getToken()->getUser();
        $clientId = $client->getId();
        $application = $this->getDoctrine()->getRepository(Application::class)->findOneBy(array('app_name' => $app));
        $appId = $application->getId();
        $categoryOb = $this->getDoctrine()->getRepository(Category::class)->findOneBy(array('category_name' => $category));

        $appConfiguration = $this->getDoctrine()->getRepository(ClientApplicationsConfiguration::class)->findOneBy(array('client' => $clientId,'application' => $appId));

        /* Cambiar la configuracion para que tenga la categoria recibida */
        
        $appConfiguration->setCategory($categoryOb);


        /* Persistir */
        $entityManager->persist($appConfiguration);
        $entityManager->flush();






        return $this->redirectToRoute('categories_configuration');
    }



    /**
     * 
     * @Route("/{appName}/{level}/change-level", name="change_category_level_route")
     * @return RedirectResponse
     *
     */
    public function changeCategoryLevel(String $appName, String $level){

        $entityManager = $this->getDoctrine()->getManager();

        /* Recuperar la configuracion de categorias del cliente */
        $client = $this->get('security.token_storage')->getToken()->getUser();
        $clientId = $client->getId();
        
        /* Tengo el appName, necesito recuperar su categoria */
        $application = $this->getDoctrine()->getRepository(Application::class)->findOneBy(array('app_name' => $appName));
        $appId = $application->getId();
        $appConfiguration = $this->getDoctrine()->getRepository(ClientApplicationsConfiguration::class)->findOneBy(array('client' => $clientId,'application' => $appId));
        $category= $appConfiguration->getCategory();
        $categoryId = $category->getId();
        /* FIN RECUPERANDO CATEGORIA */
     

        $level = $this->getDoctrine()->getRepository(ProductivityLevel::class)->findOneBy(array('level_name' => $level));

        $categoryConfiguration = $this->getDoctrine()->getRepository(ClientCategoryConfiguration::class)->findOneBy(array('client' => $clientId,'category' => $categoryId));

        /* Cambiar la configuracion para que tenga el nivel recibido */
        
        $categoryConfiguration->setProductivityLevel($level);


        /* Persistir */
        $entityManager->persist($categoryConfiguration);
        $entityManager->flush();






        return $this->redirectToRoute('categories_configuration');
    }
}
