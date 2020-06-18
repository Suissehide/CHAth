<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GeneralRepository")
 */
class General
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $sexe;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $taille;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $poids;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $imc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $systolique;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $diastolique;

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
