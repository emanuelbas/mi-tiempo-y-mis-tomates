<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesConfigurationController extends AbstractController
{
    /**
     * @Route("/categories/configuration", name="categories_configuration")
     */
    public function index()
    {
        return $this->render('categories_configuration/index.html.twig', [
            'controller_name' => 'CategoriesConfigurationController',
        ]);
    }
}
