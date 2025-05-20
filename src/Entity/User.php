<?php
namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", unique:true)]
    private string $email;

    #[ORM\Column(type:"string")]
    private string $password;

    #[ORM\Column(type:"string", length:100)]
    private ?string $firstName = null;

    #[ORM\Column(type:"string", length:100)]
    private ?string $lastName = null;

    public function getId(): ?int { return $this->id; }

    public function getUserIdentifier(): string { return $this->email; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    public function getFirstName(): ?string { return $this->firstName; }
    public function setFirstName(string $firstName): self { $this->firstName = $firstName; return $this; }

    public function getLastName(): ?string { return $this->lastName; }
    public function setLastName(string $lastName): self { $this->lastName = $lastName; return $this; }

    public function eraseCredentials(): void {
        // Clear sensitive data if needed
    }

    public function getRoles(): array {
        return ['ROLE_USER']; // ou roles stockés en BD
    }
}
