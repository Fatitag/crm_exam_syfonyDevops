<?php
// src/Controller/FactureController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    // Existing route to view a single facture
    #[Route('/facture/{id}', name: 'facture_view')]
    public function view($id)
    {
        // Fetch the facture from the database
        $facture = ['id' => $id, 'amount' => 100, 'date' => new \DateTime()]; // Mock data

        return $this->render('facture/view.html.twig', [
            'facture' => $facture
        ]);
    }

    // New route for listing all factures
    #[Route('/factures', name: 'factures')]
    public function list()
    {
        // Mock data for factures
        $factures = [
            ['id' => 1, 'amount' => 100, 'date' => new \DateTime()],
            ['id' => 2, 'amount' => 200, 'date' => new \DateTime()],
        ];

        return $this->render('page/factures.html.twig', [
            'factures' => $factures
        ]);
    }
}
