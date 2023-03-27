<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Monolog\DateTimeImmutable;
use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotNull()]
    private string $nom;
    #private string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotNull()]
    private string $prenom;

    //#[ORM\Column]
    //#[Assert\NotNull()]
    #private DateTimeImmutable $datenaissance;
    #private ?\DateTimeImmutable $datenaissance = null;
    //private Date  $datenaissance;
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datenaissance = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\NotNull()]
    #[Assert\Email(
        message: 'Le mail {{ value }} n\'est pas valide.',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 30)]
    //#[Assert\NotNull()]
    #[SecurityAssert\UserPassword(
        message: 'Wrong value for your current password message avertissement',
    )]
    private string $motdepasse;
/*
    public function __construct(){
        $this->datenaissance = new \DateTimeImmutable();
    }
*/
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

}
