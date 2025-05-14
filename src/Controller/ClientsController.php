<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientsController extends AbstractController
{
    #[Route('/clients', name: 'clients')]
    public function index(): Response
    {
        $clients = [
            [
                'id' => 1,
                'nom' => 'John',
                'prenom' => 'Doe',
                'raison_sociale' => 'Acme Corp',
                'telephone' => '0123456789',
                'adresse' => '123 Rue Principale',
                'ville' => 'Oujda',
                'pays' => 'Maroc',
                'factures' => [
                    ['id' => 101, 'montant' => 1500, 'date' => '2024-05-10'],
                    ['id' => 102, 'montant' => 2300, 'date' => '2024-06-15'],
                ]
            ],
            [
                'id' => 2,
                'nom' => 'Jane',
                'prenom' => 'Smith',
                'raison_sociale' => 'Smith Enterprises',
                'telephone' => '0987654321',
                'adresse' => '456 Rue Exemple',
                'ville' => 'Oujda',
                'pays' => 'Maroc',
                'factures' => [
                    ['id' => 103, 'montant' => 1800, 'date' => '2024-05-20'],
                    ['id' => 104, 'montant' => 2500, 'date' => '2024-07-01'],
                ]
            ],
        ];

        return $this->render('page/clients/index.html.twig', [
            'clients' => $clients
        ]);
    }

    #[Route('/clients/add', name: 'client_add')]
    public function add(): Response
    {
        return $this->render('page/clients/add.html.twig');
    }

    #[Route('/client/{id}/edit', name: 'client_edit')]
    public function edit(Request $request, $id): Response
    {
        $client = [
            'id' => $id,
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'raison_sociale' => 'Entreprise Dupont SARL',
            'telephone' => '0600123456',
            'adresse' => '12 rue des Lilas',
            'ville' => 'Oujda',
            'pays' => 'Maroc',
        ];

        if ($request->isMethod('POST')) {
            $client['nom'] = $request->request->get('nom');
            $client['prenom'] = $request->request->get('prenom');
            $client['raison_sociale'] = $request->request->get('raison_sociale');
            $client['telephone'] = $request->request->get('telephone');
            $client['adresse'] = $request->request->get('adresse');
            $client['ville'] = $request->request->get('ville');
            $client['pays'] = $request->request->get('pays');


            $this->addFlash('success', 'Client updated successfully!');
            return $this->redirectToRoute('clients');
        }

        return $this->render('page/clients/edit.html.twig', [
            'client' => $client
        ]);
    }

    #[Route('/client/{id}/delete', name: 'client_delete')]
    public function delete($id): Response
    {
        $this->addFlash('success', 'Client deleted successfully!');
        return $this->redirectToRoute('clients');
    }

    #[Route('/client/{id}', name: 'client_view')]
    public function view($id): Response
    {
        $client = [
            'id' => $id,
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'raison_sociale' => 'Entreprise Dupont SARL',
            'telephone' => '0600123456',
            'adresse' => '12 rue des Lilas',
            'ville' => 'Oujda',
            'pays' => 'Maroc',
            'factures' => [
                ['id' => 101, 'montant' => 1500, 'date' => '2024-05-10'],
                ['id' => 102, 'montant' => 2300, 'date' => '2024-06-15'],
            ]
        ];

        return $this->render('page/clients/view.html.twig', [
            'client' => $client
        ]);
    }
}
