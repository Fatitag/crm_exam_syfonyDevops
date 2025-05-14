<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request): Response
    {
        // Get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();
        // Last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('page/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
