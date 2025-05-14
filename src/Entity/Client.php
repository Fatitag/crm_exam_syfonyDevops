<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom du gérant est requis.")]
    private ?string $gerantNom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "La raison sociale est requise.")]
    private ?string $raisonSociale = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Le numéro de téléphone est requis.")]
    #[Assert\Regex(
        pattern: "/^\+?\d{6,15}$/",
        message: "Le numéro de téléphone n'est pas valide."
    )]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse est requise.")]
    private ?string $adresse = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "La ville est requise.")]
    private ?string $ville = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le pays est requis.")]
    private ?string $pays = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Facture::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $factures;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGerantNom(): ?string
    {
        return $this->gerantNom;
    }

    public function setGerantNom(string $gerantNom): static
    {
        $this->gerantNom = $gerantNom;
        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): static
    {
        $this->raisonSociale = $raisonSociale;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;
        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): static
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setClient($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): static
    {
        if ($this->factures->removeElement($facture)) {
            if ($facture->getClient() === $this) {
                $facture->setClient(null);
            }
        }

        return $this;
    }
}
