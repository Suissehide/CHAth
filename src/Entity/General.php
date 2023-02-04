<?php

namespace App\Entity;

use App\Repository\GeneralRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GeneralRepository::class)]
class General
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?int $age = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $sexe = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?int $taille = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?int $poids = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 1, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $imc = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $systolique = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $diastolique = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(?int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(?int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getImc(): ?float
    {
        return $this->imc;
    }

    public function setImc(?float $imc): self
    {
        $this->imc = $imc;

        return $this;
    }

    public function getSystolique(): ?float
    {
        return $this->systolique;
    }

    public function setSystolique(?float $systolique): self
    {
        $this->systolique = $systolique;

        return $this;
    }

    public function getDiastolique(): ?float
    {
        return $this->diastolique;
    }

    public function setDiastolique(?float $diastolique): self
    {
        $this->diastolique = $diastolique;

        return $this;
    }
}
