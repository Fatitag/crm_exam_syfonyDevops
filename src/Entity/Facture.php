<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotBlank(message: "La date est requise.")]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    #[Assert\NotBlank(message: "Le montant est requis.")]
    #[Assert\GreaterThanOrEqual(value: 0, message: "Le montant doit être positif.")]
    private ?string $montant = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Le statut est requis.")]
    #[Assert\Choice(
        choices: ["payée", "en attente", "annulée"],
        message: "Statut invalide. Choisissez entre 'payée', 'en attente' ou 'annulée'."
    )]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;
        return $this;
    }
}
