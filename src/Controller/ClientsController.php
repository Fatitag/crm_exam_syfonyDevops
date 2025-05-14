<?php
// src/Controller/ClientController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientsController extends AbstractController
{
    #[Route('/clients', name: 'clients')]
    public function clients()
    {
        // Fetch clients from the database or create mock data
        $clients = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com'],
            // Add more clients here
        ];

        return $this->render('page/clients.html.twig', [
            'clients' => $clients
        ]);
    }

    #[Route('/client/{id}/edit', name: 'client_edit')]
    public function edit($id)
    {
        // Edit logic here

        return $this->render('client/edit.html.twig');
    }

    #[Route('/client/{id}/delete', name: 'client_delete')]
    public function delete($id)
    {
        // Delete client logic here

        return $this->redirectToRoute('clients');
    }

    #[Route('/client/{id}/factures', name: 'client_factures')]
    public function factures($id)
    {
        // Fetch factures for the client

        return $this->render('facture/factures.html.twig');
    }
}
