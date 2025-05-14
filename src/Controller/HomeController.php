<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
   
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    public function login(): Response
    {
        return $this->render('login.html.twig');
    }

    
    public function dashboard(): Response
    {
        return $this->render('dashboard.html.twig');
    }
}
