<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Client;
use App\Form\ClientType;

class ClientsController extends AbstractController
{
    #[Route('/clients', name: 'clients')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('you should login to see your clients!.');
        }

        $clients = $em->getRepository(Client::class)->findBy(['user' => $user]);

        return $this->render('page/clients/index.html.twig', [
            'clients' => $clients,
        ]);
    }

    #[Route('/clients/new', name: 'client_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setUser($this->getUser());
            $em->persist($client);
            $em->flush();

            $this->addFlash('success', 'Client added with success !');

            return $this->redirectToRoute('clients');
        }

        return $this->render('page/clients/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/clients/{id}', name: 'client_view')]
public function view(Client $client): Response
{
    if ($client->getUser() !== $this->getUser()) {
        throw $this->createAccessDeniedException('you can not access to this client.');
    }

    $factures = $client->getFactures(); 

    return $this->render('page/clients/view.html.twig', [
        'client' => $client,
        'factures' => $factures,
    ]);
}


    #[Route('/clients/{id}/edit', name: 'client_edit')]
    public function edit(Request $request, Client $client, EntityManagerInterface $em): Response
    {
        if ($client->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('you can not modify this client.');
        }

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Client updated with success !');

            return $this->redirectToRoute('clients');
        }

        return $this->render('page/clients/edit.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }

    #[Route('/clients/{id}/delete', name: 'client_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, int $id, EntityManagerInterface $em): RedirectResponse
    {
        $client = $em->getRepository(Client::class)->find($id);

        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé.');
        }

        if ($client->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('you can not delete this client.');
        }

        $em->remove($client);
        $em->flush();

        $this->addFlash('success', 'Client deleted with success !');

        return $this->redirectToRoute('clients');
    }
}
