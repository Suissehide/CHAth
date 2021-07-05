<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardiovasculaireRepository")
 */
class Cardiovasculaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"export"})
     */
    private $tabac;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"export"})
     */
    private $activitePhysique;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"export"})
     */
    private $alimentation = [];

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     * @Groups({"export"})
     */
    private $facteurs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     * @Groups({"export"})
     */
    private $traitement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTabac(): ?string
    {
        return $this->tabac;
    }

    public function setTabac(?string $tabac): self
    {
        $this->tabac = $tabac;

        return $this;
    }

    public function getActivitePhysique(): ?string
    {
        return $this->activitePhysique;
    }

    public function setActivitePhysique(?string $activitePhysique): self
    {
        $this->activitePhysique = $activitePhysique;

        return $this;
    }

    public function getAlimentation(): ?array
    {
        return $this->alimentation;
    }

    public function setAlimentation(?array $alimentation): self
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    public function getFacteurs(): ?Pack
    {
        return $this->facteurs;
    }

    public function setFacteurs(?Pack $facteurs): self
    {
        $this->facteurs = $facteurs;

        return $this;
    }

    public function getTraitement(): ?Pack
    {
        return $this->traitement;
    }

    public function setTraitement(?Pack $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
    }
}
