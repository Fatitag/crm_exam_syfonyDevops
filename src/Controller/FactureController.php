<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Facture;
use App\Form\FactureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    #[Route('/facture/new/{clientId}', name: 'facture_new')]
    public function new(EntityManagerInterface $em, Request $request, int $clientId): Response
    {
        $client = $em->find(Client::class, $clientId);

        if (!$client || $client->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("You don't have access to this client.");
        }

        $facture = new Facture();
        $facture->setClient($client);

        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($facture);
            $em->flush();

            $this->addFlash('success', 'Invoice successfully added.');

            return $this->redirectToRoute('client_view', ['id' => $clientId]);
        }

        return $this->render('page/factures/add.html.twig', [
            'form' => $form->createView(),
            'client' => $client,  

        ]);
    }

    #[Route('/facture/edit/{id}', name: 'facture_edit')]
    public function edit(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $facture = $em->find(Facture::class, $id);

        if (!$facture) {
            throw $this->createNotFoundException("Invoice #$id not found.");
        }

        if ($facture->getClient()->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("You don't have access to edit this invoice.");
        }

        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Invoice successfully updated.');

            return $this->redirectToRoute('client_view', ['id' => $facture->getClient()->getId()]);
        }

        return $this->render('page/factures/edit.html.twig', [
            'form' => $form->createView(),
            'facture' => $facture,
        ]);
    }

    #[Route('/facture/delete/{id}', name: 'facture_delete', methods: ['POST'])]
public function delete(int $id, EntityManagerInterface $em, Request $request): Response
{
    $facture = $em->find(Facture::class, $id);

    if (!$facture) {
        throw $this->createNotFoundException("Invoice #$id not found.");
    }

    if ($facture->getClient()->getUser() !== $this->getUser()) {
        throw $this->createAccessDeniedException("You don't have access to delete this invoice.");
    }

    if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
        $em->remove($facture);
        $em->flush();
        $this->addFlash('danger', "Invoice #$id deleted.");
    } else {
        $this->addFlash('warning', "Invalid CSRF token. Invoice not deleted.");
    }

    return $this->redirectToRoute('client_view', ['id' => $facture->getClient()->getId()]);
}

}
