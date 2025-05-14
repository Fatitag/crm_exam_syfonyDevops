<?php
// src/Controller/FactureController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class FactureController extends AbstractController
{
    // Existing route to view a single facture
    #[Route('/facture/{id}', name: 'facture_view')]
    public function view($id)
{
    // Mock complet
    $facture = [
        'id' => $id,
        'amount' => 100,
        'date' => new \DateTime(),
        'etat' => 'Payée',
        'commentaire' => 'Facture réglée à la livraison'
    ];

    return $this->render('page/factures/view.html.twig', [
        'facture' => $facture
    ]);
}


    // New route for listing all factures
    #[Route('/factures', name: 'factures')]
    public function list()
    {
        // Mock data for factures
        $factures = [
    [
        'id' => 1,
        'amount' => 100,
        'date' => new \DateTime(),
        'etat' => 'Payée',
        'commentaire' => 'Paiement effectué en totalité',
    ],
    [
        'id' => 2,
        'amount' => 200,
        'date' => new \DateTime(),
        'etat' => 'Non payée',
        'commentaire' => 'Client en retard',
    ],
];


        return $this->render('page/factures/index.html.twig', [
            'factures' => $factures
        ]);
    }
#[Route('/facture/add', name: 'facture_add')]
public function add(Request $request)
{
    if ($request->isMethod('POST')) {
        // Normally you would persist the data
        $this->addFlash('success', 'Facture ajoutée avec succès.');
        return $this->redirectToRoute('factures');
    }

    // ✅ Make sure you're using render()
    return $this->render('page/factures/add.html.twig');
}

#[Route('/facture/edit/{id}', name: 'facture_edit')]
public function edit($id, Request $request)
{
    // Facture simulée
    $facture = ['id' => $id, 'numero' => 'F123', 'date' => new \DateTime(), 'amount' => 250, 'etat' => 'payee', 'note' => 'RAS'];

    if ($request->isMethod('POST')) {
        $this->addFlash('success', 'Facture modifiée avec succès.');
        return $this->redirectToRoute('factures');
    }

    return $this->render('page/factures/edit.html.twig', ['facture' => $facture]);
}

#[Route('/facture/delete/{id}', name: 'facture_delete')]
public function delete($id)
{
    $this->addFlash('danger', "Facture #$id supprimée.");
    return $this->redirectToRoute('factures');
}

}
