<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DecesRepository")
 */
class Deces
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $causePrincipale;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $codagePrincipal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $causeSecondaire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $codageSecondaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCausePrincipale(): ?string
    {
        return $this->causePrincipale;
    }

    public function setCausePrincipale(?string $causePrincipale): self
    {
        $this->causePrincipale = $causePrincipale;

        return $this;
    }

    public function getCodagePrincipal(): ?int
    {
        return $this->codagePrincipal;
    }

    public function setCodagePrincipal(?int $codagePrincipal): self
    {
        $this->codagePrincipal = $codagePrincipal;

        return $this;
    }

    public function getCauseSecondaire(): ?string
    {
        return $this->causeSecondaire;
    }

    public function setCauseSecondaire(?string $causeSecondaire): self
    {
        $this->causeSecondaire = $causeSecondaire;

        return $this;
    }

    public function getCodageSecondaire(): ?int
    {
        return $this->codageSecondaire;
    }

    public function setCodageSecondaire(?int $codageSecondaire): self
    {
        $this->codageSecondaire = $codageSecondaire;

        return $this;
    }
}
