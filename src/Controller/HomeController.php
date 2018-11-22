<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
    * @Route("/", name="home")
    */
    public function home()
    {
         return $this->render('home.html.twig');
    }

    /**
    * @Route("download", name="download")
    */
    public function download()
    {
         return $this->render('download/download.html.twig');
    }
}