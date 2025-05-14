<?php

// src/Controller/PageController.php


// src/Controller/PageController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    
    public function dashboard()
    {
        return $this->render('page/dashboard.html.twig');
    }
}

